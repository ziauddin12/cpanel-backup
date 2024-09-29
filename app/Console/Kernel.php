<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        // Run the backup command at midnight
        $schedule->command('backup:create')->dailyAt('00:00');

        // Run the move backup command 3 hours after the backup is created
        $schedule->command('backup:move')->dailyAt('03:00');

        // Run the upload to Google Drive command 3 hours after the backup is moved
        $schedule->command('backup:upload')->dailyAt('06:00');
		
		// Run the upload to Google Drive command 3 hours after the backup is moved
        $schedule->command('backup:cleanup')->dailyAt('09:00');
    }

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}
