<?php

namespace App\Console\Commands\maintenance;

use Illuminate\Console\Command;

class MaintenanceServiceDailyInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:infoMaintenanceService';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send every month for info maintenance service';

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

        $Query = new QueryMaintenanceService();
        $Query->maintenanceServiceInfo();
         
        $this->info('Successfully sent daily');
    }
}
