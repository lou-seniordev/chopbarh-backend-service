<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaystackBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paystack_banks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('auth_code')->unique();
            $table->string('account_number');
            $table->string('bank');
            $table->string('bank_code');
            $table->string('last_digits');
            $table->string('playerId');
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
        Schema::dropIfExists('paystack_banks');
    }
}
