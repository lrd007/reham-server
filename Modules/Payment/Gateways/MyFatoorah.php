<?php

namespace Modules\Payment\Gateways;

use App;
use Illuminate\Http\Request;
use Modules\Order\Entities\Order;
use AymanElmalah\MyFatoorah\MyFatoorah as MyFatoorahPay;
use Modules\Registration\Entities\Registration;

class MyFatoorah
{
    public $label;
    public $description;

    public function __construct()
    {
        $this->label = setting('myfatoorah_label');
        $this->description = setting('myfatoorah_description');
    }

    public function gateway()
    {
        $gateway = new MyFatoorahPay();

        return $gateway;
    }

    public function purchase(Order $order, Request $request)
    {
        $response = $this->gateway()->createInvoice([
            'NotificationOption' => 'all',
            'MobileCountryCode' => '+965',
            'DisplayCurrencyIso' => 'KD',
            'Language' => App::getLocale(),
            'InvoiceValue' => $request->input('amount'),
            'CustomerName' => $request->input('billing.first_name') . " " . $request->input('billing.last_name'),
            'CustomerEmail' => $request->input('customer_email'),
            'CustomerMobile' => $request->input('customer_phone'),
            'CallBackUrl' => $this->getSuccessUrl($request->input('success_url'), "OrderID=" . $order->id),
            'ErrorUrl' => $this->getFailureUrl($request->input('failure_url'), "OrderID=" . $order->id),
        ]);

        return $response;
    }

    public function register(Registration $register, Request $request)
    {
        $response = $this->gateway()->createInvoice([
            'NotificationOption' => 'all',
            'MobileCountryCode' => '+965',
            'DisplayCurrencyIso' => 'KWD',
            'Language' => App::getLocale(),
            'InvoiceValue' => $request->input('amount'),
            'CustomerName' => $request->input('first_name') . " " . $request->input('last_name'),
            'CustomerEmail' => $request->input('email'),
            'CustomerMobile' => $request->input('mobile'),
            'CallBackUrl' => $this->getSuccessUrl($request->input('success_url'), "RegID=" . $register->id),
            'ErrorUrl' => $this->getFailureUrl($request->input('failure_url'), "RegID=" . $register->id),
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
