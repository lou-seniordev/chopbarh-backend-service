<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWithdrawalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('amount');
            $table->string('channel');
            $table->string('customer_id');
            $table->dateTimeTz('withdrawal_date');
            $table->string('gameTransactionId');
            $table->string('playerId');
            $table->integer('transaction_fees');
            $table->string('transaction_reference');
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
        Schema::dropIfExists('withdrawals');
    }
}
