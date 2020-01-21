<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRaveCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rave_cards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('auth_code');
            $table->string('card_type');
            $table->string('email');
            $table->string('expiry');
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
        Schema::dropIfExists('rave_cards');
    }
}
