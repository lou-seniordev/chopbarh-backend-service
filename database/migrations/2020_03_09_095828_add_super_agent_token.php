<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSuperAgentToken extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('super_agents', function (Blueprint $table) {
            //
            $table->string('password');
            $table->string('token');
            $table->dateTime('token_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('super_agents', function (Blueprint $table) {
            //
            $table->dropColumn('password');
            $table->dropColumn('token');
            $table->dropColumn('token_at');
        });
    }
}
