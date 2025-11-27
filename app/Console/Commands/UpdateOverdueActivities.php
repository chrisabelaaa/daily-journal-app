<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Activity;
use Carbon\Carbon;

class UpdateOverdueActivities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'activities:update-overdue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update activities with overdue deadlines to Unfinished status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for overdue activities...');
        
        $updatedCount = Activity::where('status', '!=', 'Done')
            ->where('deadline', '<', now())
            ->whereNotNull('deadline')
            ->update(['status' => 'Unfinished']);
        
        $this->info("Updated {$updatedCount} overdue activities to Unfinished status.");
        
        return Command::SUCCESS;
    }
}
