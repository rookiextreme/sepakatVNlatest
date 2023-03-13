<?php

namespace App\Console\Commands\assessment;

use App\Console\Commands\assessment\QueryAssessmentService;
use Illuminate\Console\Command;

class AssessmentSafetyServiceDailyInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:infoAssessmentSafetyService';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send every month for info assessment safety service';

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

        $Query = new QueryAssessmentService();
        $Query->assessmentServiceInfo();
         
        $this->info('Successfully sent daily');
    }
}
