<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\GoogleDriveController;

class UploadToGoogleDriveCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:upload';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
		$googleDriveController  = new GoogleDriveController();
        $googleDriveController->uploadGoogleDrive();

        $this->info('Backup move successfully!');
    }
}
