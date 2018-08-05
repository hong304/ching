<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActivationTimeToActivationKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activation_keys', function (Blueprint $table) {
            $table->timestamp('activation_time')->nullable()->after('activation_key');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activation_keys', function (Blueprint $table) {
            //
            $table->dropColumn('activation_time');
        });
    }
}
