<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\MoveController;

class MoveBackupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:move';

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
		$moveController  = new MoveController();
        $moveController->moveBackup();

        $this->info('Backup move successfully!');
    }
}
