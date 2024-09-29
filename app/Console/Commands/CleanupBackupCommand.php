<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class CleanupBackupCommand extends Command
{
    protected $signature = 'backup:cleanup';
    protected $description = 'Delete backup files older than 3 hours';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
		 // Current directory path
        $current_directory_path = base_path(); // Laravel's base path

        // Your cPanel username
        $cpanel_username = 'multient';

        // Custom folder for backup
        $custom_folder = $current_directory_path . '/backups';
		
		// Root path calculation to search for the backup file
        $correctRootPath = explode($cpanel_username, $current_directory_path)[0];

        // Pattern to match the expected backup file name
        $backup_pattern = $correctRootPath . $cpanel_username . '/backup-' . date('n.j.Y') . '_*.tar.gz'; 
		
		$backup_file = null;

        $files = glob($backup_pattern);
		
        if (!empty($files)) {
            $backup_file = $files[0]; // Get the first matching file
        }

        if ($backup_file && File::exists($backup_file)) {
            // Delete the backup file
            File::delete($backup_file);
            $this->info('Backup file deleted: ' . $backup_file);
        } else {
            $this->info('No backup file found to delete.');
        }
    }
}
