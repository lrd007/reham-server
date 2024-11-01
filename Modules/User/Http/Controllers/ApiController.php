<?php

namespace Modules\User\Http\Controllers;

use Auth;
use App\Country;
use iPayFSSNetPipe;
use App\Mail\WelcomeMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Modules\User\Entities\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Coupon\Entities\Coupon;
use Modules\Course\Entities\Course;
use App\Notifications\ResetPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Modules\Payment\Entities\Payment;
use Modules\Program\Entities\Program;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Validator;
use Modules\Payment\Entities\PaymentDetail;
use Modules\Subscriber\Entities\Subscriber;
use Illuminate\Contracts\Support\Renderable;
use Modules\Subscriber\Entities\SubscriberProgram;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\F;
use Illuminate\Auth\Notifications\ResetPassword as NotificationsResetPassword;



class ApiController extends Controller
{





    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            //   'remember_me' => 'boolean',
        ]);

        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $token =  $user->createToken($user->name . ' token')->plainTextToken;
            return response()->json(['success' => true, 'message' => 'Login Successful', 'token' => $token, 'data' => User::find($user->id, ['id', 'name', 'email'])]);
        } else {
            return response()->json(['error' => 'Email or Password is incorrect'], 401);
        }
    }

    public function register(Request $request)
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email'    => 'unique:users|required',
            'password' => 'required|min:6',
            'mobile_no' => 'required',
            'country_id' => 'required',
        ];

        $input = $request->only(
            'first_name',
            'last_name',
            'email',
            'password',
            'mobile_no',
            'country_id',
        );
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()]);
        }

        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => false,
        ]);

        Mail::to($user->email)->send(new WelcomeMail($user));

        $token =  $user->createToken($user->name . ' token')->plainTextToken;

        $susbcriber = Subscriber::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'mobile_no' => $request->mobile_no,
            'country_id' => $request->country_id,
            'user_id' => $user->id,
        ]);

        return response()->json(['success' => true, 'message' => 'User registered successfully', 'token' => $token, 'data' => $user]);
    }

    public function countries()
    {
        return response()->json(['success' => true, 'countries' => Country::all()]);
    }

    public function user_password_reset(Request $request)
    {
        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ];

        $input = $request->only(
            'current_password',
            'new_password',
            'new_password_confirmation'
        );
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()]);
        }

        $user = auth('sanctum')->user();

        if (!(Hash::check($request->get('current_password'), $user->password))) {
            // The passwords matches
            return response()->json(['success' => false, 'error' => __("Your current password does not matches with the password")]);
        }

        if (strcmp($request->get('current_password'), $request->get('new_password')) == 0) {
            // Current password and new password same
            return response()->json(['success' => false, 'error' => __("New Password cannot be same as your current password")]);
        }

        //Change Password
        $user->password = bcrypt($request->get('new_password'));
        $user->save();

        return response()->json(['success' => true, 'message' => 'Password Reset successful.']);
    }

    public function user_details_get(Request $request)
    {
        $user = auth('sanctum')->user();
        return response()->json(['success' => true, 'data' => $user->subscriber]);
    }

    public function user_details_post(Request $request)
    {
        $filePath = uploads_files('subscriber');
        $user = auth('sanctum')->user();
        $subscriber = $user->subscriber;
        $subscriber->first_name = $request->first_name;
        $subscriber->last_name = $request->last_name;
        $subscriber->mobile_no = $request->mobile_no;
        $subscriber->country_id = $request->country_id;
        $subscriber->gender = $request->gender;
        $subscriber->dob = $request->dob;

        // $subscriber->image = uploadFile($request, 'subscriber_', 'file', 'image', $filePath);
        //dd($request->image);
        $image = $request->image;  // your base64 encoded
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = 'subscriber_' . time() . '.' . 'png';
        \File::put(public_path() . '/uploads/files/subscriber/' . $imageName, base64_decode($image));

        $subscriber->image = $imageName;

        $subscriber->save();
        $user->name = $subscriber->first_name . ' ' . $subscriber->last_name;
        $user->save();
        return response()->json(['success' => true, 'data' => $subscriber]);
    }

    public function add_to_wishlist(Request $request)
    {
        $user = auth('sanctum')->user();
        $course = Course::find($request->course_id);
        $user->wish($course, 'wishlist');

        return response()->json(['success' => true, 'message' => 'Course Added to Wishlist']);
    }

    public function remove_from_wishlist(Request $request)
    {
        $user = auth('sanctum')->user();
        $course = Course::find($request->course_id);
        $user->unwish($course, 'wishlist');

        return response()->json(['success' => true, 'message' => 'Course Removed from Wishlist']);
    }

    public function get_wishlist(Request $request)
    {
        $user = auth('sanctum')->user();
        $wishlist_items = $user->wishlist('wishlist');
        return response()->json(['success' => true, 'data' => $wishlist_items]);
    }

    public function add_to_cart(Request $request)
    {

        $user = auth('sanctum')->user();
        $program = Program::findOrFail($request->course_id);
		
        // check if user has already purcashed this course.
        $susbcriber = $user->subscriber;

        if ($susbcriber){

            // dd($susbcriber);
            $user_courses = SubscriberProgram::where('subscriber_id', $susbcriber->id)->where('program_id', $program->id)->first();
        } else{
            $user_courses = null;
        }

        /*if (!$course->courseFees()->exists()) {
            return response()->json(['success' => false, 'message' => 'Course Cannot be Purchased.', 'course' => $course]);
        }*/

        if (!$user_courses) {
            $user->wish($program, 'cart_items');
            return response()->json(['success' => true, 'message' => 'Added to Cart', 'course' => $program]);
        } else {
            return response()->json(['success' => false, 'message' => 'Already Purchased.', 'course' => $program]);
        }
    }

    public function remove_from_cart(Request $request)
    {
        $user = auth('sanctum')->user();
        $program = Program::find($request->course_id);
        $user->unwish($program, 'cart_items');

        return response()->json(['success' => true, 'message' => 'Course Removed from Cart']);
    }

    public function get_cart(Request $request)
    {
        $user = auth('sanctum')->user();
        $wishlist_items = $user->wishlist('cart_items');

        $programs = [];
        foreach ($wishlist_items as $course) {
            /*$item->courseFees->first();*/

            $program = $course;//->programs()->first();
            $programs[] = $program->id;
        }

        $programs = array_unique($programs);
        $programs = Program::whereIn('id', $programs)->get();

        $data = [];
        foreach ($programs as $program) {
            $program = Program::with(['sections','sections.elements','courses' => function ($query) {
                $query->with('courseFees')->withCount('chapters');
            },'courses.chapters.lessons'])->find($program->id);
            // Calculate the total price of the program.
            $total_price=0;
            foreach($program->courses as $course)
            {
                $total_price += $course->courseFees()->pluck('sale_fee')->first();
            }

            $program['total_price']=$total_price;
            $data[] = $program;
        }

        return response()->json(['success' => true, 'data' => collect($data)->values()->toArray()]);
    }

    public function my_courses()
    {
        $user = auth('sanctum')->user();

        // Admin User.
        if($user->isAdmin())
        {
            // $programs = Program::with(['courses.courseFees', 'courses.bonusMaterials.materials', 'courses.chapters.lessons' => function ($query) {
            //     $query->orderBy('id', 'ASC');
            // }])->withTrashed()->get();
            $courses = Course::withCount('chapters')->with(['getStartedFiles', 'bonusMaterials.materials', 'chapters.lessons' => function ($query) {
                $query->orderBy('id', 'ASC');
            }])->get();
            return response()->json(['success' => true,'data' => $courses]);
        }
        else{
            $courses = $user->subscriber->subscribePrograms()->with(['course', 'course.getStartedFiles', 'course.bonusMaterials.materials', 'course.chapters.lessons' => function ($query) {
                $query->orderBy('id', 'ASC');
            }])->get();

            $my_courses = collect();

            foreach ($courses as $course) {
                $my_courses->push($course->course);
            }

            return response()->json(['success' => true, 'data' => $my_courses]);
        }

    }

    public function isAdmin()
    {
        $user = auth('sanctum')->user();
        if ($user->is_admin) {
            return response()->json(['isAdmin' => true]);
        } else {
            return response()->json(['isAdmin' => false]);
        }
    }
    private $apiContext;
    public function checkout(Request $request)
    {

        $user = auth('sanctum')->user();
        $amount = 0;
//        $courses_array = explode(",", $request->courses);
        //$courses_array = explode(",", $request->courses);
        $programs = $user->wishlist('cart_items');
        if (!$user->subscriber) {

            Subscriber::create([
                'first_name' => $user->name,
                'last_name' => $user->name,
                'mobile_no' => '000',
                'country_id' => 1,
                'user_id' => $user->id,
            ]);

            $user->load('subscriber');
        }
        //$courses = Course::find($courses_array);
        $discount_amount = 0;
        $coupon_id = null;

        if ($request->coupon_id) {
            $coupon = Coupon::find($request->coupon_id);
            $discount_amount = $coupon->amount;
            $coupon_id = $coupon->id;
        }

        $gateway = $request->payment_type;
        //dd($request->all(),$gateway);
        $TranTrackid = mt_rand();

        foreach ($programs as $program) {

            foreach ($program->courses as $course) {
                // dd($course->courseFees()->pluck('sale_fee')->first());
                $amount += $course->courseFees()->pluck('sale_fee')->first();
            }
        }

        $amount = $amount - $discount_amount;

        $payment = new Payment();
        $payment->trackid = $TranTrackid;
        $payment->amount = $amount;
        $payment->subscriber_id = $user->subscriber->id;
        $payment->payment_type = $request->payment_type;
        $payment->gateway = $gateway;
        $payment->status = 'pending';
        $payment->coupon_id = $coupon_id;
        $payment->discount = $discount_amount;

        Log::info($payment);

        $payment->save();

        foreach ($programs as $program) {

            foreach ($program->courses as $course) {
                $payment_detail = new PaymentDetail();
                $payment_detail->payment_id = $payment->id;
                $payment_detail->course_id = $course->id;
                $payment_detail->program_id = $program->id;
                $payment_detail->course_package_id = $course->courseFees()->first()->coursePackage->id;
                $payment_detail->amount = $course->courseFees()->pluck('sale_fee')->first();
                $payment_detail->save();
            }
        }


        if ($request->payment_type == "paypal") {
            $clientId = env('PAYPAL_LIVE_CLIENT_ID');
            $clientSecret = env('PAYPAL_LIVE_CLIENT_SECRET');

            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $paypalToken = $provider->getAccessToken();

            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => route('paypalSuccess')."?pay_id=".$TranTrackid,
                    "cancel_url" => route('paypalFailed'),
                ],
                "purchase_units" => [
                    0 => [
                        "amount" => [
                            "currency_code" => "USD",
                            "value" => round($amount*setting('paypal_rate'), 2)
                        ]
                    ]
                ]
            ]);
            Log::info($paypalToken);

            if (isset($response['id']) && $response['id'] != null) {

                foreach ($response['links'] as $links) {
                    if ($links['rel'] == 'approve') {
                        $payment->paymentid =  $TranTrackid;
                        $payment->save();
                        return response()->json(['success' => true, 'url' => $links['href']]);
                    }
                }

                return redirect()
                    ->route('paypalFailed')
                    ->with('error', 'Something went wrong.');

            } else {
                return redirect()
                    ->route('paypalSuccess')
                    ->with('error', $response['message'] ?? 'Something went wrong.');
            }

            /*$apiContext = new \PayPal\Rest\ApiContext(
                new \PayPal\Auth\OAuthTokenCredential(
                    $clientId,     // Replace with your client ID
                    $clientSecret  // Replace with your client secret
                )
            );*/

            /*

            // dd(route('paypalSuccess'));
            \Log::info("PayPalClient", [ route('paypalSuccess') ]);
            $provider = new PayPalClient;
            $config = Config::get('paypal');
            $provider->setApiCredentials($config);
            $provider->getAccessToken();
            $data = $provider->createOrder([
                "intent" => "CAPTURE",
                "purchase_units" => [
                    [
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
						\Log::info($data);
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
            }*/
        }
        else if ($gateway == 'myfatoorah' || $gateway == 'knet' ||  $gateway == 'credit_card') {


            // MYFATOORAH STARTS HERE.

            /* ------------------------ Configurations ---------------------------------- */
            //Test
            $apiURL = config('app.myfatoorah_mode')=='live' ? 'https://api.myfatoorah.com' : 'https://apitest.myfatoorah.com' ;
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
        } else if ($gateway == 'kfh') {
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
                return response()->json(['success' => true, 'url' => 'https://kpaytest.com.kw/kpg/PaymentHTTP.htm?param=paymentInit' . '&trandata=' . $param]);
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

    public function forgotPasswordPage(Request $request)
    {
        return view('frontend.forgot_password_link');
    }

    public function forgot_password_link(Request $request)
    {
        $input = $request->only('email');
        // $validator = Validator::make($input, [
        //     'email' => "required|email|exists:users,email"
        // ]);
        // if ($validator->fails()) {
        //     return response(['errors' => $validator->errors()->all()], 422);
        // }
        // NotificationsResetPassword
        $response =  Password::sendResetLink($input);
        // dd($response);
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

	public function emptyWishlist (Request $request){
	\DB::table('wishlist')->truncate();
	return redirect()->back();
	//return response()->json(['success' => true, 'message' => 'All records from Wishlist table have been removed']);

	}


}
