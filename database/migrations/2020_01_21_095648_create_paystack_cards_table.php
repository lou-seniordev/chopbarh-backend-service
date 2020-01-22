<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaystackCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paystack_cards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('auth_code')->unique();
            $table->string('card_type');
            $table->string('cvv');
            $table->string('expiry_month');
            $table->string('expiry_year');
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
        Schema::dropIfExists('paystack_cards');
    }
}
