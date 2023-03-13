<?php

namespace App\Console\Commands\summon;

use Illuminate\Console\Command;

class DailySendInfoSummon extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:infoSummon';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send everyday for info summon to Person in Charge';

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
         
        $this->info('Successfully sent daily quote to everyone.');
    }
}
