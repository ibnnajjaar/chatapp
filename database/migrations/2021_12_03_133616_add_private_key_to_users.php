<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPrivateKeyToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('private_key_one')->nullable();
            $table->string('private_key_two')->nullable();

            $table->unsignedInteger('prime_p')->nullable();
            $table->unsignedInteger('prime_q')->nullable();
            $table->unsignedInteger('private_key')->nullable();
            $table->unsignedInteger('public_key')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('private_key_one');
            $table->dropColumn('private_key_two');

            $table->dropColumn('prime_p');
            $table->dropColumn('prime_q');
            $table->dropColumn('private_e');
            $table->dropColumn('public_d');
        });
    }
}
