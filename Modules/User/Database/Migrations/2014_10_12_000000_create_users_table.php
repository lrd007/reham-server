<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->tinyInteger('is_admin')->default(0);
            $table->dateTime('last_login')->nullable();
            $table->dateTime('last_activity')->nullable();
            $table->string('ip_address')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });

        // admin / demo user
        DB::table('users')->insert([
            'name' => 'Administrator',
            'email' => 'admin@demo.com',
            'password' => bcrypt('secret'),
            'is_admin' => 1,
        ]);

        DB::table('users')->insert([
            'name' => 'Regular User',
            'email' => 'user@demo.com',
            'password' => bcrypt('secret'),
            'is_admin' => 0,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
