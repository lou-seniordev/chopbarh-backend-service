<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTranGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tran_games', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('TranID')->unique();
            $table->string('TranType');
            $table->bigInteger('TranTime');
            $table->string('GAME_NAME');
            $table->string('GAME_TYPE');
            $table->text('GAME_PLAYERS');
            $table->integer('GAME_TOTAL_REVENUE');
            $table->string('GAME_WIN_AMOUNTS');
            $table->integer('GAME_ENTRY_FEE');
            $table->string('GAME_CHECK_AMOUNTS');
            $table->bigInteger('GAME_START');
            $table->bigInteger('GAME_END');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tran_games');
    }
}
