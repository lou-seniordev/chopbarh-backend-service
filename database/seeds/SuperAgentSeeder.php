<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SuperAgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('super_agents')->insert([
            "email" => "kylianmbappe@psg.com",
            "first_name" => "Kylian",
            "last_name" => "Mbappe",
            "phone_number" => "08038894657",
            "gender" => "Male",
            "DOB" => "1997-01-05",
            "address" => "12 Obalende, House 7a",
            "alternate_phone" => "09082349089",
            "city" => "Ibadan",
            "status" => "PENDING",
            "type" => "Business",
            "description" => "I am a Business owner interested in this",
            "state" => "Oyo",
            "password" => bcrypt("super*agent1"),
            "token" => Str::random(20),
            "token_at" => "2020-03-09"
        ]);
    }
}
