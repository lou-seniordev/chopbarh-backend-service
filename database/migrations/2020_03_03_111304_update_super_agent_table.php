<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSuperAgentTable extends Migration
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
            $table->string('address');
            $table->string('alternate_phone');
            $table->string('city');
            $table->string('status');
            $table->string('type');
            $table->string('description');
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
            $table->dropColumn('address');
            $table->dropColumn('alternate_phone');
            $table->dropColumn('city');
            $table->dropColumn('status');
            $table->dropColumn('type');
            $table->dropColumn('description');
        });
    }
}
