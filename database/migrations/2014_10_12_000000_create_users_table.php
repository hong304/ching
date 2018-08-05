<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('facebook_id')->nullable();
            $table->string('password')->nullable();
            $table->string('password_old')->nullable();
            $table->boolean('admin')->default(false);
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('nick_name')->nullable();
            $table->string('avatar')->nullable();
            $table->string('gender')->nullable();
            $table->boolean('activated')->default(false);
            $table->boolean('subscription')->default(true);
            $table->date('birthday')->nullable();
            $table->string('postcode')->nullable();
            $table->text('address')->nullable();
            $table->string('country_code')->nullable();
            $table->string('country_old')->nullable();
            $table->string('tel_mobile')->nullable();
            $table->string('tel_home')->nullable();
            $table->rememberToken();
            $table->dateTime('last_login_time')->nullable();
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
        Schema::dropIfExists('users');
    }
}
