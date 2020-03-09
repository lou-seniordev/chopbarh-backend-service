<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SuperAgent;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ExpireSuperAgentToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'token:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire Super Agent Token every 24 hours';

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
        $expired = SuperAgent::where('token_at', '<=', Carbon::now()->addDays(-1)->toDateTimeString())->get();

        foreach ($expired as $exp) {
            $exp->update([
                'token' => Str::random(20),
                'token_at' => Carbon::now()->toDateTimeString()
            ]);
        }
    }
}
