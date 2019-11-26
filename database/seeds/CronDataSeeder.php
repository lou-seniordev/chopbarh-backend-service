<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CronDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('cron_data')->insert([
            'eventKey' => 'WEB_PLAYER_LIST',
            'lastID' => ' '
        ]);

        DB::table('cron_data')->insert([
            'eventKey' => 'WEB_TRAN_PLAYER',
            'lastID' => ' '
        ]);

        DB::table('cron_data')->insert([
            'eventKey' => 'WEB_TRANSACTION',
            'lastID' => ' '
        ]);
    }
}
