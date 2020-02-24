<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRefundDisputesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('refund_disputes', function (Blueprint $table) {
            //
            $table->dropColumn('paid_at');
            $table->string('gateway');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('refund_disputes', function (Blueprint $table) {
            //
            $table->dropColumn('gateway');
            $table->bigInteger('paid_at');
        });
    }
}
