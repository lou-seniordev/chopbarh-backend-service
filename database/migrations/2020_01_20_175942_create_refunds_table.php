<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('refunds');

        Schema::create('refunds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('amount');
            $table->string('bank');
            $table->string('customer_id');
            $table->dateTimeTz('refund_date');
            $table->string('gameTransactionId');
            $table->string('playerId');
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
        Schema::dropIfExists('refunds');
    }
}
