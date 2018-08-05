<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuditLoginsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_logins', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('from')->nullable();
            $table->string('ip_address');
            $table->string('continent')->nullable();
            $table->string('country')->nullable();
            $table->string('browser',32)->nullable();
            $table->string('device',32)->nullable();
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
        Schema::dropIfExists('audit_logins');
    }
}
