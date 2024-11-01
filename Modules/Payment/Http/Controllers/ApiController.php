<?php

namespace Modules\Payment\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use iPayFSSNetPipe;
use LamaLama\Wishlist\Wishlist;
use LamaLama\Wishlist\WishlistFacade;
use Modules\Course\Entities\Course;
use Modules\Payment\Entities\Payment;
use Modules\Payment\Notifications\OrderMail;
use Modules\Program\Entities\Program;
use Modules\Subscriber\Entities\SubscriberProgram;
use DB;
use Illuminate\Support\Facades\Notification;
use Modules\Payment\Notifications\PaymentFailedMail;

class ApiController extends Controller
{
    // Myfatoorah callback

    public function MyFatoorahCallback(Request $request)
    {
        /* ------------------------ Configurations ---------------------------------- */
        //Test
        //$apiURL = 'https://apitest.myfatoorah.com';
        $apiKey = config('app.myfatoorah_key');

        //Live
        $apiURL = config('app.myfatoorah_mode')=='live' ? 'https://api.myfatoorah.com' : 'https://apitest.myfatoorah.com' ;
        //$apiKey = ''; //Live token value to be placed here: https://myfatoorah.readme.io/docs/live-token


        /* ------------------------ Call getPaymentStatus Endpoint ------------------ */
        //Inquiry using paymentId
        $keyId   = $request->paymentId;
        $KeyType = 'paymentId';

        //Inquiry using invoiceId
        /*$keyId   = '613842';
        $KeyType = 'invoiceId';*/

        //Fill POST fields array
        $postFields = [
            'Key'     => $keyId,
            'KeyType' => $KeyType
        ];
        //Call endpoint
        $json       = $this->callAPI("$apiURL/v2/getPaymentStatus", $apiKey, $postFields);

        //Display the payment result to your customer
        // dd($json->Data);

        $payment = Payment::where('trackid', $json->Data->InvoiceId)->first();
        $user = $payment->subscriber->user;
        if ($json->IsSuccess && $json->Data->InvoiceStatus == "Paid") {/*$json->Data->InvoiceStatus == "Paid"*/
            $payment->status = "success";
            $payment->payment_type = $json->Data->InvoiceTransactions[0]->PaymentGateway;
            $payment->paymentid = $request->paymentId;
            $payment->save();


            foreach ($payment->paymentDetail as $payment_detail) {

                $course = Course::find($payment_detail->course_id);
                if ($course) {

                    $subscriber_courses = new SubscriberProgram();
                    $subscriber_courses->program_id = $payment_detail->program_id;
                    $subscriber_courses->course_id = $course->id;
                    $subscriber_courses->start_date = now()->format('Y-m-d');
                    $subscriber_courses->end_date = now()->addDays($course->courseFees()->first()->coursePackage->days)->format('Y-m-d');
                    $subscriber_courses->subscriber_id = $payment->subscriber_id;
                    $subscriber_courses->course_fee_id = $course->courseFees()->pluck('id')->first();
                    $subscriber_courses->fee = $course->courseFees()->pluck('sale_fee')->first();
                    $subscriber_courses->save();
                }
            }

            // remove all items from cart for this user.
            $clearCart = DB::table('wishlist')->where('user_id', $user->id)->where('collection_name', 'cart_items')->delete();

            $user->notify(new OrderMail($user->subscriber->first_name, $payment->amount, $payment->trackid, $payment->paymentid));
            Notification::route('mail', 'reham@reham.com')->notify(new OrderMail($user->subscriber->first_name, $payment->amount, $payment->trackid, $payment->paymentid));
            Notification::route('mail', 'finance@reham.com')->notify(new OrderMail($user->subscriber->first_name, $payment->amount, $payment->trackid, $payment->paymentid));
            Notification::route('mail', 'hello@reham.com')->notify(new OrderMail($user->subscriber->first_name, $payment->amount, $payment->trackid, $payment->paymentid));

            return redirect()->away('https://reham.com/payment-invoice?status=success&paymentid=' . $request->paymentId . '&trackid=' . $payment->trackid . '&amount=' . $payment->amount);
        } else if ($json->Data->InvoiceStatus == "Pending") {
            $payment->status = "failed";
            $payment->payment_type = $json->Data->InvoiceTransactions[0]->PaymentGateway;
            $payment->paymentid = $request->paymentId;
            $payment->save();
            $user->notify(new PaymentFailedMail($user->subscriber->first_name, $payment->amount, $payment->trackid, $payment->paymentid));
            Notification::route('mail', 'reham@reham.com')->notify(new PaymentFailedMail($user->subscriber->first_name, $payment->amount, $payment->trackid, $payment->paymentid));
            Notification::route('mail', 'finance@reham.com')->notify(new PaymentFailedMail($user->subscriber->first_name, $payment->amount, $payment->trackid, $payment->paymentid));
            Notification::route('mail', 'hello@reham.com')->notify(new PaymentFailedMail($user->subscriber->first_name, $payment->amount, $payment->trackid, $payment->paymentid));
            return redirect()->away('https://reham.com/payment-invoice?status=failed&paymentid=' . $request->paymentId . '&trackid=' . $payment->trackid . '&amount=' . $payment->amount);
        } else {
            $payment->status = "failed";
            $payment->payment_type = $json->Data->InvoiceTransactions[0]->PaymentGateway;
            $payment->paymentid = $request->paymentId;
            $payment->save();
            return redirect()->away('https://reham.com/payment-invoice?status=NULL&paymentid=' . $request->paymentId . '&trackid=' . $payment->trackid . '&amount=' . $payment->amount);
        }

        /* ------------------------ Functions --------------------------------------- */
        /*
 * Call API Endpoint Function
 */
    }



    /* ------------------------ Functions --------------------------------------- */
    /*
 * Call API Endpoint Function
 */

    function callAPI($endpointURL, $apiKey, $postFields = [])
    {

        $curl = curl_init($endpointURL);
        curl_setopt_array($curl, array(
            CURLOPT_CUSTOMREQUEST  => 'POST',
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

    /* -------------------------------------------------------------------------- */










    // private $live_url = 'https://admin.reham.com/';
    // private $staging_url = 'https://reham.mukkancom.dev/';
    // private $local_url = "http://reham_web.test/";
    // private $url;

    // public function __construct()
    // {
    //     $this->url = $this->local_url;
    // }

    public function CreditCardPaymentSuccess(Request $request)
    {
        $trandata = $request->trandata;

        require(app_path('iPayFSSNetPipe.php'));
        $myObj = new iPayFSSNetPipe();
        $myObj->setResourcePath(app_path("")); //Resource File Path, provide the actual resource path
        $myObj->setKeystorePath(app_path("/")); //KeystorePath File provide the actual Keystore path
        $myObj->setAlias(config('app.AliasName')); //Terminal Alias Name // 1 – Purchase
        $myObj->parseEncryptedRequest(trim($trandata));
        dd($myObj->getResult(), $myObj->getPaymentId(), $myObj->getTransId(), $myObj->getAmt(), $myObj->getTrackId());
        // if ($myObj->getResult() == "NOT+CAPTURED" || $myObj->getResult() == "NOT CAPTURED") {
        // }

        $payment = Payment::where('trackid', $myObj->getTrackId())->first();
        $user = $payment->subscriber->user;

        // Captured.
        if ($myObj->getResult() == "CAPTURED") {
            $payment->paymentid = $myObj->getPaymentId();
            $payment->save();
            $myObj->setAction("8");
            $myObj->setType("C");
            $myObj->setAmt($myObj->getAmt());
            $myObj->setCurrency("414");
            $myObj->setLanguage("en");
            $myObj->setResponseURL(route('CreditCardPaymentInquiry'));
            $myObj->setErrorURL(route('CreditCardPaymentInquiry'));
            $myObj->setTransId($myObj->getPaymentId());
            $myObj->setUdf5("PaymentID");
            $user->notify(new OrderMail($user->subscriber->first_name,$payment->amount,$payment->trackid,$payment->paymentid));

            if (trim($myObj->performTransactionHTTP()) != 0) {
                $myObj->getError(); // Problem in connecting the Payment Gateway
            } else {
                //To redirect the web address.
                redirect()->away($myObj->getwebAddress()); // To connect Payment Gateway
            }
        } else if ($myObj->getResult() == "NOT CAPTURED" || $myObj->getResult() == "NOT+CAPTURED") {
            $payment->status = "failed";
            $payment->paymentid = $myObj->getPaymentId();
            $payment->save();

        } else {
            $payment->status = "pending";
            $payment->paymentid = $myObj->getPaymentId();
            $payment->save();
            $user->notify(new PaymentFailedMail($user->subscriber->first_name, $payment->amount, $payment->trackid, $payment->paymentid));

        }
        return redirect()->away('https://reham.com/payment-invoice?status=failed&paymentid=' . $payment->paymentid . '&trackid=' . $payment->trackid . '&amount=' . $payment->amount);
        //return response()->json(['success' => true, 'message' => 'Payment completed']);
    }

    public function CreditCardPaymentFailed(Request $request)
    {
        dd($request->all());
    }


    public function CreditCardPaymentInquiry(Request $request)
    {
        $trandata = $request->trandata;
        // dd($trandata);
        require(app_path('iPayFSSNetPipe.php'));
        $myObj = new iPayFSSNetPipe();
        $myObj->setResourcePath(app_path("")); //Resource File Path, provide the actual resource path
        $myObj->setKeystorePath(app_path("/")); //KeystorePath File provide the actual Keystore path
        $myObj->setAlias(config('app.AliasName')); //Terminal Alias Name // 1 – Purchase
        $myObj->parseEncryptedResult(trim($trandata));
        dd($myObj->getResult(), $myObj->getPaymentId(), $myObj->getTransId(), $myObj->getAmt(), $myObj->getTrackId());

        $payment = Payment::where('trackid', $myObj->getTrackId())->first();
        $user = $payment->subscriber->user;

        foreach ($payment->paymentDetail as $payment_detail) {

            $program = Program::find($payment_detail->course_id);
            if ($program) {

                foreach ($program->courses as $course) {
                    $subscriber_courses = new SubscriberProgram();
                    $subscriber_courses->program_id = $program->id;
                    $subscriber_courses->course_id = $course->id;
                    $subscriber_courses->start_date = now()->format('Y-m-d');
                    $subscriber_courses->end_date = now()->addDays($course->courseFees()->first()->coursePackage->days)->format('Y-m-d');
                    $subscriber_courses->subscriber_id = $payment->subscriber_id;
                    $subscriber_courses->course_fee_id = $course->courseFees()->pluck('id')->first();
                    $subscriber_courses->fee = $course->courseFees()->pluck('sale_fee')->first();
                    $subscriber_courses->save();
                }
            }
        }

        // remove all items from cart for this user.
        $clearCart = DB::table('wishlist')->where('user_id', $user->id)->where('collection_name', 'cart_items')->delete();

        // $user->notify(new OrderMail($user->subscriber->first_name,$payment->amount,$payment->trackid,$payment->paymentid));
        return redirect()->away('https://reham.com/payment-invoice?status=success&paymentid=' . $payment->paymentid . '&trackid=' . $payment->trackid . '&amount=' . $payment->amount);
    }

    public function KnetPaymentSuccess(Request $request)
    {
        $is_local = config('app.env') === "local";

        if (!$is_local) {

            $termResourceKey = config('app.termResourceKey');
            $ResTranData = $request['trandata'];
            if ($ResTranData != null) {
                //Decryption logice starts
                $decrytedData = $this->decryptString($ResTranData, $termResourceKey);
            }

            parse_str($decrytedData, $response);

            $paymentSuccessful = $response['result'] == "CAPTURED";

            $trackid = $response['trackid'];
            $paymentid = $response['paymentid'];
        } else {

            $paymentSuccessful = true;
            $trackid = $request['trackid'];
            $paymentid = $request['paymentid'];
        }

        dd($is_local);
        $payment = Payment::where('trackid', $trackid)->first();
        $user = $payment->subscriber->user;
        if ($paymentSuccessful) {
            $payment->status = "success";
            $payment->paymentid = $paymentid;
            $payment->save();
            $user = $payment->subscriber->user;
            foreach ($payment->paymentDetail as $payment_detail) {

                $course = Course::find($payment_detail->course_id);
                if ($course) {

                    $subscriber_courses = new SubscriberProgram();
                    $subscriber_courses->program_id = $payment_detail->program_id;
                    $subscriber_courses->course_id = $course->id;
                    $subscriber_courses->subscriber_id = $payment->subscriber_id;
                    $subscriber_courses->start_date = now()->format('Y-m-d');
                    $subscriber_courses->end_date = now()->addDays($course->courseFees()->first()->coursePackage->days)->format('Y-m-d');
                    $subscriber_courses->course_fee_id = $course->courseFees()->pluck('id')->first();
                    $subscriber_courses->fee = $course->courseFees()->pluck('sale_fee')->first();
                    $subscriber_courses->save();
                }
            }

            // remove all items from cart for this user.
            $clearCart = DB::table('wishlist')->where('user_id', $user->id)->where('collection_name', 'cart_items')->delete();

            $user->notify(new OrderMail($user->subscriber->first_name,$payment->amount,$payment->trackid,$payment->paymentid));
            return redirect()->away('https://reham.com/payment-invoice?status=success&paymentid=' . $payment->paymentid . '&trackid=' . $payment->trackid . '&amount=' . $payment->amount);
        } else if ($response['result'] == "NOT CAPTURED") {
            $payment->status = "failed";
            $payment->paymentid = $response['paymentid'];
            $payment->save();
        } else {
            $payment->status = "pending";
            $payment->paymentid = $response['paymentid'];
            $payment->save();
        }

        return redirect()->away('https://reham.com/payment-invoice?status=failed&paymentid=' . $payment->paymentid . '&trackid=' . $payment->trackid . '&amount=' . $payment->amount);
    }

    public function KnetPaymentFailed(Request $request)
    {
        dd($request->all());
    }


    //Decryption Method for AES Algorithm Starts

    function decryptString($code, $key)
    {
        $code =  $this->hex2ByteArray(trim($code));
        $code = $this->byteArray2String($code);
        $iv = $key;
        $code = base64_encode($code);
        $decrypted = openssl_decrypt($code, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
        return $this->pkcs5_unpad($decrypted);
    }

    function hex2ByteArray($hexString)
    {
        $string = hex2bin($hexString);
        return unpack('C*', $string);
    }


    function byteArray2String($byteArray)
    {
        $chars = array_map("chr", $byteArray);
        return join($chars);
    }


    function pkcs5_unpad($text)
    {
        $pad = ord($text[strlen($text) - 1]);
        if ($pad > strlen($text)) {
            return false;
        }
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) {
            return false;
        }
        return substr($text, 0, -1 * $pad);
    }

    //Decryption Method for AES Algorithm Ends
}
