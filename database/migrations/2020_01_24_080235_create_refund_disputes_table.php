<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDisputesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refund_disputes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('amount');
            $table->string('bank');
            $table->string('customer_id');
            $table->dateTimeTz('refund_date');
            $table->string('gameTransactionId');
            $table->bigInteger('paid_at');
            $table->string('playerId');
            $table->string('transaction_reference')->unique();
            $table->string('status');
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
        Schema::dropIfExists('refund_disputes');
    }
}
