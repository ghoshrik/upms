<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SanctionLimitMaster;
use App\Models\Department;
use Illuminate\Support\Facades\DB;

class UpdateSanctionLimitTitles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sanction-limit:update-titles';
    //Command = php artisan sanction-limit:update-titles//
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the title field in the sanction limit masters table';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $sanctionLimits = SanctionLimitMaster::all();
        $total = $sanctionLimits->count();
        $updatedCount = 0;

        // Show the total number of records to be migrated
        $this->info("Total title to be migrated: {$total}");

        // Create a progress bar
        $bar = $this->output->createProgressBar($total);
        $bar->start();

        foreach ($sanctionLimits as $sanctionLimit) {
            $project_type = DB::table('project_types')->where('department_id', $sanctionLimit->department_id)->first();

            if ($project_type) {
                SanctionLimitMaster::where('id', $sanctionLimit->id)
                    ->update(['project_type_id' => $project_type->id]);
                $updatedCount++;
            }

            // Advance the progress bar
            $bar->advance();
        }

        // Finish the progress bar
        $bar->finish();

        // Print a new line after the progress bar
        $this->newLine();

        // Summary message
        $this->info("{$updatedCount}/{$total} titles have been updated successfully.");

        return 0;
    }
}
