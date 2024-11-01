<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Country;
use App\Notifications\ResetPassword;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Validator;
use Auth;
use Illuminate\Auth\Events\PasswordReset;
use Modules\Subscriber\Entities\Subscriber;
use Illuminate\Support\Facades\Hash;
use iPayFSSNetPipe;
use Modules\Course\Entities\Course;
use Modules\Payment\Entities\Payment;
use Modules\Payment\Entities\PaymentDetail;
use Modules\User\Entities\User;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\F;
use Illuminate\Support\Facades\Password;
use Modules\Subscriber\Entities\SubscriberProgram;
use Illuminate\Support\Str;
use Modules\Affiliate\Entities\Affiliate;
use Modules\Coupon\Entities\Coupon;
use Modules\Program\Entities\Program;
use Config;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Log;


class PaymentsController extends Controller
{

    public function checkPaymentMethod(Request $request){

        if(isset($request['payment_type'])){
            if(
                $request['payment_type'] == 'knet' ||
                $request['payment_type'] == 'credit_card' ||
                $request['payment_type'] == 'paypal'
            ){
                $this->checkout($request);
            }
            else{
                return redirect()->back();
            }
        }else{
            return redirect()->back();
        }
    }
    
    public function checkout(Request $request)
    {
        $user = auth('sanctum')->user();
        $amount = 0;
        $courses_array = explode(",", $request->courses);
        $courses = Course::find($courses_array);
        $discount_amount = 0;
        $coupon_id = null;

        if ($request->coupon_id) {
            $coupon = Coupon::find($request->coupon_id);
            $discount_amount = $coupon->amount;
            $coupon_id = $coupon->id;
        }

        $gateway = $request->payment_type == 'paypal' ? 'paypal' : setting('landing_page_payment_gateway');

        $TranTrackid = mt_rand();

        foreach ($courses as $course) {
            // dd($course->courseFees()->pluck('sale_fee')->first());
            $amount += $course->courseFees()->pluck('sale_fee')->first();
        }

        $amount = $amount - $discount_amount;

        //affiliate fields
        $commission = null;
        $affiliate_id = null;

        if ($request->affiliate_code) {
            $affiliate = Affiliate::where('code', $request->affiliate_code)->first();
            $affiliate_id = $affiliate->id;
            if ($affiliate->type == 'fixed') {
                $commission = $affiliate->value;
            } else {
                $commission = ($amount * $affiliate->value) / 100;
            }
        }

        $payment = new Payment();
        $payment->trackid = $TranTrackid;
        $payment->amount = $amount;
        $payment->subscriber_id = $user->subscriber->id;
        $payment->payment_type = $request->payment_type;
        $payment->gateway = $gateway;
        $payment->status = 'pending';
        $payment->coupon_id = $coupon_id;
        $payment->discount = $discount_amount;

        //affiliate fields
        $payment->affiliate_id = $affiliate_id;
        $payment->affiliate_commission = $commission;

        $payment->save();

        foreach ($courses as $course) {
            $payment_detail = new PaymentDetail();
            $payment_detail->payment_id = $payment->id;
            $payment_detail->course_id = $course->id;
            $payment_detail->course_package_id = $course->courseFees()->first()->coursePackage->id;
            $payment_detail->amount = $course->courseFees()->pluck('sale_fee')->first();
            $payment_detail->save();
        }


        if ($request->payment_type == "paypal") {
            $provider = new PayPalClient;
            $config = Config::get('paypal');
            $provider->setApiCredentials($config);
            $provider->getAccessToken();
            $data = $provider->createOrder([
                "intent" => "CAPTURE",
                "purchase_units" => [
                    0 => [
                        "amount" => [
                            "currency_code" => "USD",
                            "value" => round($amount*setting('paypal_rate'), 2),
                        ]
                    ]
                ],
                "application_context" => [
                    "cancel_url" => route('paypalFailed'),
                    "return_url" => route('paypalSuccess'),
                ]
            ]);
            $key = 'rel';
            $val = 'approve';
            if ($data['status'] == 'CREATED') {

                // save token into payments table.
                $payment->paymentid = $data['id'];
                $payment->save();

                $link_arr = NULL;
                foreach ($data['links'] as $linkkey => $linkval) {
                    if ($linkval[$key] == $val) {
                        $link_arr = $linkval;
                        break;
                    }
                }
                //  return redirect($link_arr['href']);
                return response()->json(['success' => true, 'url' => $link_arr['href']]);
            }
        }


        if ($gateway == 'myfatoorah') {


            // MYFATOORAH STARTS HERE.

            /* ------------------------ Configurations ---------------------------------- */
            //Test
            $apiURL = config('app.myfatoorah_mode') == 'live' ? 'https://api.myfatoorah.com' : 'https://apitest.myfatoorah.com';
            $apiKey = config('app.myfatoorah_key');

            //Live
            //$apiURL = 'https://api.myfatoorah.com';
            //$apiKey = ''; //Live token value to be placed here: https://myfatoorah.readme.io/docs/live-token


            /* ------------------------ Call SendPayment Endpoint ----------------------- */
            //Fill customer address array
            /* $customerAddress = array(
  'Block'               => 'Blk #', //optional
  'Street'              => 'Str', //optional
  'HouseBuildingNo'     => 'Bldng #', //optional
  'Address'             => 'Addr', //optional
  'AddressInstructions' => 'More Address Instructions', //optional
  ); */

            //Fill invoice item array
            /* $invoiceItems[] = [
  'ItemName'  => 'Item Name', //ISBAN, or SKU
  'Quantity'  => '2', //Item's quantity
  'UnitPrice' => '25', //Price per item
  ]; */

            //Fill POST fields array
            $postFields = [
                //Fill required data
                'NotificationOption' => 'Lnk', //'SMS', 'EML', or 'ALL'
                'InvoiceValue'       => $amount,
                'CustomerName'       => $user->name,
                //Fill optional data
                //'DisplayCurrencyIso' => 'KWD',
                // 'MobileCountryCode'  => '+965',
                //'CustomerMobile'     => '1234567890',
                'CustomerEmail'      => $user->email,
                'CallBackUrl'        => route('MyFatoorahCallback'),
                'ErrorUrl'           => route('MyFatoorahCallback'), //or 'https://example.com/error.php'
                //'Language'           => 'en', //or 'ar'
                //'CustomerReference'  => 'orderId',
                //'CustomerCivilId'    => 'CivilId',
                //'UserDefinedField'   => 'This could be string, number, or array',
                //'ExpiryDate'         => '', //The Invoice expires after 3 days by default. Use 'Y-m-d\TH:i:s' format in the 'Asia/Kuwait' time zone.
                //'SourceInfo'         => 'Pure PHP', //For example: (Symfony, CodeIgniter, Zend Framework, Yii, CakePHP, etc)
                //'CustomerAddress'    => $customerAddress,
                //'InvoiceItems'       => $invoiceItems,
            ];

            //Call endpoint
            $data = $this->sendPayment($apiURL, $apiKey, $postFields);

            //You can save payment data in database as per your needs
            $invoiceId   = $data->InvoiceId;
            $paymentLink = $data->InvoiceURL;
            $payment->trackid = $invoiceId;
            $payment->save();
            return response()->json(['success' => true, 'url' => $paymentLink]);

            // MYFATOORAH ENDS HERE.
        } else if ($gateway == 'boubyan') {
            // Knet
            if ($request->payment_type == "knet") {
                $TranAmount = $amount;
                $TranportalId = config('app.TranportalId');
                $ReqTranportalId = "id=" . $TranportalId;
                $ReqTranportalPassword = config('app.ReqTranportalPassword');
                $ReqAmount = "amt=" . $TranAmount;
                $ReqTrackId = "trackid=" . $TranTrackid;
                $ReqCurrency = "currencycode=414";

                /* Transaction language, THIS MUST BE ALWAYS USA OR AR. */
                $ReqLangid = "langid=USA";
                $ReqAction = "action=1";
                $ResponseUrl = route('KnetPaymentSuccess');
                $ReqResponseUrl = "responseURL=" . $ResponseUrl;
                $ErrorUrl = route('KnetPaymentFailed');
                $ReqErrorUrl = "errorURL=" . $ErrorUrl;
                $ReqUdf1 = "udf1=Test1";
                $ReqUdf2 = "udf2=Test2";
                $ReqUdf3 = "udf3=Test3";
                $ReqUdf4 = "udf4=Test4";
                $ReqUdf5 = "udf5=Test5";

                /* Now merchant sets all the inputs in one string for encrypt and then passing to the Payment Gateway URL */
                $param = $ReqTranportalId . "&" . $ReqTranportalPassword . "&" . $ReqAction . "&" . $ReqLangid . "&" . $ReqCurrency . "&" . $ReqAmount . "&" . $ReqResponseUrl . "&" . $ReqErrorUrl . "&" . $ReqTrackId . "&" . $ReqUdf1 . "&" . $ReqUdf2 . "&" . $ReqUdf3 . "&" . $ReqUdf4 . "&" . $ReqUdf5;
                $termResourceKey = config('app.termResourceKey');
                $param = $this->encryptAES($param, $termResourceKey) . "&tranportalId=" . $TranportalId . "&responseURL=" . $ResponseUrl . "&errorURL=" . $ErrorUrl;
                //header("Location: https://kpaytest.com.kw/kpg/PaymentHTTP.htm?param=paymentInit" . "&trandata=" . $param); /* send request and redirect to TEST */
                //header("Location: https://www.kpay.com.kw/kpg/PaymentHTTP.htm?param=paymentInit"."&trandata=".$param); /* send request and redirect to PRODUCTION */
                return response()->json(['success' => true, 'url' => 'https://kpay.com.kw/kpg/PaymentHTTP.htm?param=paymentInit' . '&trandata=' . $param]);
            }
            // credit card
            else if ($request->payment_type == "credit_card") {
                //Include or Require
                require(app_path('iPayFSSNetPipe.php'));

                //Initialization
                $myObj = new iPayFSSNetPipe();
                $myObj->setResourcePath(app_path("")); //Resource File Path, provide the actual resource path
                $myObj->setKeystorePath(app_path("/")); //KeystorePath File provide the actual Keystore path
                $myObj->setAlias(config('app.AliasName')); //Terminal Alias Name // 1 – Purchase
                $myObj->setAction("1"); //Transaction Action Code //Transaction Currency
                $myObj->setCurrency("414"); //Currency Code
                $myObj->setLanguage("en"); //Language
                //Success URL
                $myObj->setResponseURL(route('CreditCardPaymentSuccess'));
                //Error URL
                $myObj->setErrorURL(route('CreditCardPaymentFailed'));
                //Transaction Amount
                $myObj->setAmt($amount);
                $myObj->setTrackId($TranTrackid);
                //Merchant Track ID. Unique number generated by the Merchant $myObj->setTrackId(“123456789”);
                //User Defined Fields
                //Actual value should be provided properly during the UAT and production.
                $myObj->setUdf1("udf1");
                $myObj->setUdf2("udf2");
                $myObj->setUdf3("udf3");
                $myObj->setUdf4("udf4");
                $myObj->setUdf5("udf5");

                // For Hosted Payment Integration( Single Step integration), the method to be called is
                if (trim($myObj->performPaymentInitializationHTTP()) != 0) {
                    $myObj->getError(); // Problem in connecting the Payment Gateway
                } else {
                    //To redirect the web address.
                    //  header("location:" . $myObj->getwebAddress()); //To connect Gateway
                    return response()->json(['success' => true, 'url' => $myObj->getwebAddress()]);
                }
                /** End of Request Processing**/
            } else {
                return response()->json(['success' => false, 'message' => 'Incorrect Payment Type.']);
            }
        }
    }


    //AES Encryption Method Starts
    function encryptAES($str, $key)
    {
        $str = $this->pkcs5_pad($str);
        $encrypted = openssl_encrypt($str, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $key);
        $encrypted = base64_decode($encrypted);
        $encrypted = unpack('C*', ($encrypted));
        $encrypted = $this->byteArray2Hex($encrypted);
        $encrypted = urlencode($encrypted);
        return $encrypted;
    }


    function pkcs5_pad($text)
    {
        $blocksize = 16;
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }
    function byteArray2Hex($byteArray)
    {
        $chars = array_map("chr", $byteArray);
        $bin = join($chars);
        return bin2hex($bin);
    }


    //MYFATOORAH FUNCTIONS
    /* ------------------------ Functions --------------------------------------- */
    /*
 * Send Payment Endpoint Function
 */

    function sendPayment($apiURL, $apiKey, $postFields)
    {

        $json = $this->callAPI("$apiURL/v2/SendPayment", $apiKey, $postFields);
        return $json->Data;
    }

    //------------------------------------------------------------------------------
    /*
 * Call API Endpoint Function
 */

    function callAPI($endpointURL, $apiKey, $postFields = [], $requestType = 'POST')
    {

        $curl = curl_init($endpointURL);
        curl_setopt_array($curl, array(
            CURLOPT_CUSTOMREQUEST  => $requestType,
            CURLOPT_POSTFIELDS     => json_encode($postFields),
            CURLOPT_HTTPHEADER     => array("Authorization: Bearer $apiKey", 'Content-Type: application/json'),
            CURLOPT_RETURNTRANSFER => true,
        ));

        $response = curl_exec($curl);
        $curlErr  = curl_error($curl);

        curl_close($curl);

        if ($curlErr) {
            //Curl is not working in your server
            die("Curl Error: $curlErr");
        }

        $error = $this->handleError($response);
        if ($error) {
            die("Error: $error");
        }

        return json_decode($response);
    }

    //------------------------------------------------------------------------------
    /*
 * Handle Endpoint Errors Function
 */

    function handleError($response)
    {

        $json = json_decode($response);
        if (isset($json->IsSuccess) && $json->IsSuccess == true) {
            return null;
        }

        //Check for the errors
        if (isset($json->ValidationErrors) || isset($json->FieldsErrors)) {
            $errorsObj = isset($json->ValidationErrors) ? $json->ValidationErrors : $json->FieldsErrors;
            $blogDatas = array_column($errorsObj, 'Error', 'Name');

            $error = implode(', ', array_map(function ($k, $v) {
                return "$k: $v";
            }, array_keys($blogDatas), array_values($blogDatas)));
        } else if (isset($json->Data->ErrorMessage)) {
            $error = $json->Data->ErrorMessage;
        }

        if (empty($error)) {
            $error = (isset($json->Message)) ? $json->Message : (!empty($response) ? $response : 'API key or API URL is not correct');
        }

        return $error;
    }

    // FORGOT PASSWORD
    public function forgot_password(Request $request)
    {
        // dd('here');
        $input = $request->only('email');
        $validator = Validator::make($input, [
            'email' => "required|email|exists:users"
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }
        $response =  Password::sendResetLink($input);
        if ($response == Password::RESET_LINK_SENT) {
            $message = "Mail send successfully";
        } else {
            $message = "Email could not be sent to this email address";
        }
        //$message = $response == Password::RESET_LINK_SENT ? 'Mail send successfully' : GLOBAL_SOMETHING_WANTS_TO_WRONG;
        $response = ['data' => '', 'message' => $message];
        return response($response, 200);
    }

    public function reset_password(Request $request)
    {
        // dd('here');
        $input = $request->only('email', 'token', 'password', 'password_confirmation');
        $validator = Validator::make($input, [
            'token' => 'required',
            'email' => 'required|email|exists:users',
            'password' => 'required|confirmed|min:6',
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }
        $response = Password::reset($input, function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->save();
            //$user->setRememberToken(Str::random(60));
            event(new PasswordReset($user));
        });
        if ($response == Password::PASSWORD_RESET) {
            $message = "Password reset successfully";
        } else {
            $message = "Token Error!";
        }
        $response = ['data' => '', 'message' => $message];
        return response()->json($response);
    }
}
