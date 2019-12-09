<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTranTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tran_transfers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('TranID')->unique();
            $table->string('TranType');
            $table->bigInteger('TranTime');
            $table->string('TRANSFER_TYPE');
            $table->integer('TRANSFER_AMOUNT');
            $table->string('TRANSFER_FROM');
            $table->string('TRANSFER_TO');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tran_transfers');
    }
}
