<?php

namespace App\Console\Commands;

use App\Http\Controllers\GameSpark\GameSpark;
use Illuminate\Console\Command;

class FetchPlayer extends Command
{
    use GameSpark;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gamespark:fetchplayer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch players from GameSpark';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $this->fetchPlayerList();
    }
}
