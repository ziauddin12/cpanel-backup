<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\BackupController;

class BackupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:create';

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
		$backupController = new BackupController();
        $backupController->initiateBackup();

        $this->info('Backup created successfully!');
    }
}
