<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepositDisputesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposit_disputes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('amount');
            $table->string('channel');
            $table->string('customer_id');
            $table->dateTimeTz('deposit_date');
            $table->string('gateway');
            $table->string('playerId');
            $table->string('transaction_reference')->unique();
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
        Schema::dropIfExists('deposit_disputes');
    }
}
