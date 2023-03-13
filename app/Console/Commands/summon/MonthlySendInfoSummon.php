<?php

namespace App\Console\Commands\summon;

use App\Mail\Scheduler\SchedulerSummonNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MonthlySendInfoSummon extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monthly:infoSummon';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send every month for info summon to Person in Charge';

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
     * @return int
     */
    public function handle()
    {

        $Query = new Query();
        $Query->summonInfo();
         
        $this->info('Successfully sent monthly');
    }
}
