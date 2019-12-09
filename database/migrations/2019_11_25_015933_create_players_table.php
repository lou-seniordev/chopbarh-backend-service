<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('PlayerID')->unique();
            $table->bigInteger('CreatedTime');
            $table->string('Email');
            $table->integer('CBCoins');
            $table->string('DeviceID');
            $table->string('SEX');
            $table->tinyInteger('PlayerStatus');
            $table->integer('RealCoins');
            $table->string('NickName');
            $table->bigInteger('LastTimeStamp');
            $table->string('PhoneNum');
            $table->date('DOB');
            $table->string('FullName');
            $table->string('ImageID');
            $table->integer('TotalWinning');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('players');
    }
}
