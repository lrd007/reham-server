<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAffiliatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliates', function (Blueprint $table) {
            $table->id();
            $table->string('name_en')->nullable();
            $table->string('name_ar')->nullable();
            $table->string('course_url')->nullable();
            $table->string('payment_link')->nullable();
            $table->string('slug')->nullable();
            $table->string('status')->nullable();;
            $table->date('start_date');
            $table->date('end_date');
            $table->string('contract')->nullable();
            $table->string('invoice')->nullable();
            $table->string('image')->nullable();
            $table->string('bonus_material')->nullable();
            $table->timestamp('schedule')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('affiliates');
    }
}
