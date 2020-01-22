<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('amount');
            $table->string('channel');
            $table->string('customer_id');
            $table->dateTimeTz('deposit_date');
            $table->string('gameTransactionId');
            $table->string('gateway');
            $table->string('playerId');
            $table->string('refId')->unique();
            $table->integer('transaction_fees');
            $table->string('transaction_reference')->unique();
            $table->string('status');
            $table->bigInteger('paid_at');
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
        Schema::dropIfExists('deposits');
    }
}
