<?php

namespace App\Console;

use App\Jobs\ExpireSuperAgentToken;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        Commands\FetchPlayer::class,
        Commands\FetchTransaction::class,
        Commands\FetchTranPlayer::class,
        Commands\VerifyTransaction::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('gamespark:fetchplayer')->everyMinute();
        $schedule->command('gamespark:fetchtransaction')->everyMinute();
        $schedule->command('gamespark:fetchtranplayer')->everyMinute();

        $schedule->command('token:expire')->everyMinute();

        $schedule->command('cloud:verifytransaction')->everyThirtyMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
