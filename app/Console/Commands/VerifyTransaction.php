<?php

namespace App\Console\Commands;

use App\Http\Controllers\Traits\CloudFunction;
use App\Models\Deposit;
use Illuminate\Console\Command;
use Log;

class VerifyTransaction extends Command
{
    use CloudFunction;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cloud:verifytransaction';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verify transaction to Cloud Function';

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
        $deposits = Deposit::where('status', 'PENDING')
            ->orderBy('deposit_date')
            ->limit(60)
            ->get();

        foreach ($deposits as $deposit) {
            $this->verifyTransaction($deposit->toArray());
        }
    }
}
