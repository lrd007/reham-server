<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title', 350)->nullable();
            $table->tinyInteger('send_to')->default(0)->comment('0:User, 1:Group');
            $table->dateTime('schedule')->nullable();
            $table->longText('message')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0:Saved, 1:Sent, 2: Schedule');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
