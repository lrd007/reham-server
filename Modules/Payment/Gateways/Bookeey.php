<?php

namespace Modules\Payment\Gateways;

use Illuminate\Http\Request;
use Modules\Order\Entities\Order;
use Modules\Payment\BookeeyPay;
use Modules\Registration\Entities\Registration;

class Bookeey
{
    public $label;
    public $description;

    public function __construct()
    {
        $this->label = setting('bookeey_label');
        $this->description = setting('bookeey_description');
    }

    public function gateway()
    {
        $endpoint = setting('bookeey_test_mode') ? 'https://apps.bookeey.com/pgapi/api/' : null;

        $gateway = new BookeeyPay($endpoint);
        $gateway->setSecretKey(setting('bookeey_secret_key'));
        $gateway->setPayFor(setting('bookeey_payfor'));
        $gateway->setProductId(setting('bookeey_product_id'));
        $gateway->setMerchantId(setting('bookeey_merchant_id'));
        $gateway->setSubMerchantId(setting('bookeey_sub_merchant_id'));
        $gateway->setAppType(setting('bookeey_app_type'));
        $gateway->setAppVersion(setting('bookeey_app_version'));
        $gateway->setApiVersion(setting('bookeey_api_version'));
        $gateway->setDbRqst(setting('bookeey_dbrqst'));

        return $gateway;
    }

    public function purchase(Order $order, Request $request)
    {
        $response = $this->gateway()->paymentRequestLinkCreate([
            'payment_method' => (!empty($request->input('btype'))) ? $request->input('btype') : 'KNET',
            'merchant_txn_id' => mt_rand(1000000, 9999999),
            'amount' => $request->input('amount'),
            'user_session_id' => $request->session()->get('_token'),
            'customer_name' => $request->input('billing.first_name') . " " . $request->input('billing.last_name'),
            'customer_phone' => $request->input('customer_phone'),
            'success_url' => $this->getSuccessUrl($request->input('success_url'), "OrderID=" . $order->id),
            'failure_url' => $this->getFailureUrl($request->input('failure_url'), "OrderID=" . $order->id),
        ]);

        return $response;
    }

    public function register(Registration $register, Request $request)
    {
        $response = $this->gateway()->paymentRequestLinkCreate([
            'payment_method' => (!empty($request->input('btype'))) ? $request->input('btype') : 'KNET',
            'merchant_txn_id' => mt_rand(1000000, 9999999),
            'amount' => $request->input('amount'),
            'user_session_id' => $request->session()->get('_token'),
            'customer_name' => $request->input('first_name') . " " . $request->input('last_name'),
            'customer_phone' => $request->input('mobile'),
            'success_url' => $this->getSuccessUrl($request->input('success_url'), "RegID=" . $register->id),
            'failure_url' => $this->getFailureUrl($request->input('failure_url'), "RegID=" . $register->id),
        ]);

        return $response;
    }

    private function getSuccessUrl($route, $args)
    {
        return route($route, [$args]);
    }

    private function getFailureUrl($route, $args)
    {
        return route($route, [$args]);
    }
}
