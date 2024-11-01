<?php

namespace Modules\Payment\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Payment\Facades\Gateway;
use Modules\Payment\Gateways\BankTransfer;
use Modules\Payment\Gateways\Bookeey;
use Modules\Payment\Gateways\CheckPayment;
use Modules\Payment\Gateways\COD;
use Modules\Payment\Gateways\MyFatoorah;

class GatewayServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerBookeey();
        $this->registerMyFatoorah();
        $this->registerCashOnDelivery();
        $this->registerBankTransfer();
        $this->registerCheckPayment();
    }

    private function enabled($paymentMethod)
    {
        return setting("{$paymentMethod}_enabled");
    }

    private function registerCashOnDelivery()
    {
        if ($this->enabled('cod')) {
            Gateway::register('cod', new COD);
        }
    }

    private function registerBankTransfer()
    {
        if ($this->enabled('bank_transfer')) {
            Gateway::register('bank_transfer', new BankTransfer);
        }
    }

    private function registerCheckPayment()
    {
        if ($this->enabled('check_payment')) {
            Gateway::register('check_payment', new CheckPayment);
        }
    }

    private function registerMyFatoorah()
    {
        if ($this->enabled('myfatoorah')) {
            Gateway::register('myfatoorah', new MyFatoorah);
        }
    }

    private function registerBookeey()
    {
        if ($this->enabled('bookeey')) {
            Gateway::register('bookeey', new Bookeey);
        }
    }
}
