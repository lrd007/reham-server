<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Setting\Entities\Setting;

class CreateSettingTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('setting_id')->unsigned();
            $table->string('locale', 10);
            $table->longText('value');

            $table->unique(['setting_id', 'locale']);
            $table->foreign('setting_id')->references('id')->on('settings')->onDelete('cascade');
        });

        // Bookeey Test Setting
        Setting::setMany([
            'supported_countries' => ['KW'],
            'default_country' => 'KW',
            'supported_locales' => ['en', 'ar'],
            'default_locale' => 'en',
            'default_timezone' => 'Asia/Kuwait',
            'cookie_bar_enabled' => true,
            'supported_currencies' => ['KD'],
            'default_currency' => 'KD',
            'send_order_invoice_email' => false,
            'admin_email' => 'admin@reham.test',
            'local_pickup_cost' => 0,
            'flat_rate_cost' => 0,
            'bookeey_label' => 'Pay via KNET or Credit Card',
            'bookeey_description' => 'You will be redirected to KNET or Credit Card website to complete your purchase securely.',
            'bookeey_app_type' => 'WEB',
            'bookeey_app_version' => '2.0.5',
            'bookeey_api_version' => '2.0.0',
            'bookeey_product_id' => 'Ecom',
            'bookeey_merchant_id' => 'mer20000168',
            'bookeey_secret_key' => '0414948',
            'bookeey_sub_merchant_id' => 'subm2000160',
            'bookeey_payfor' => 'Ecom',
            'bookeey_dbrqst' => 'PY_Ecom',
            'bookeey_enabled' => '1',
            'bookeey_test_mode' => '1',
            'myfatoorah_enabled' => '1'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('setting_translations');
    }
}
