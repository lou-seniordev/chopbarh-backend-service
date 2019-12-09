<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTranPlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tran_players', function (Blueprint $table) {
            $table->string('ID')->primary();
            $table->string('TranID');
            $table->string('PlayerID');
            $table->integer('AMOUNT');
            $table->string('Target');
            $table->integer('Coins');
            $table->string('Mode');
            $table->integer('Cashs');
            $table->bigInteger('TimeStamp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tran_players');
    }
}
