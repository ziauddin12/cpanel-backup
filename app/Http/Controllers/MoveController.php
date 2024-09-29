<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MoveController extends Controller
{
    public function moveBackup()
    {
        // Current directory path
        $current_directory_path = base_path(); // Laravel's base path

        // Your cPanel username
		$cpanel_username = env('CPANEL_USERNAME');

        // Custom folder for backup
        $custom_folder = $current_directory_path . '/backups';

        // Ensure the custom folder exists
        if (!is_dir($custom_folder)) {
            mkdir($custom_folder, 0755, true);
        }

        // Root path calculation to search for the backup file
        $correctRootPath = explode($cpanel_username, $current_directory_path)[0];

        // Pattern to match the expected backup file name
        $backup_pattern = $correctRootPath . $cpanel_username . '/backup-' . date('n.j.Y') . '_*.tar.gz'; 

        $backup_file = null;

        $files = glob($backup_pattern);
        if (!empty($files)) {
            $backup_file = $files[0]; // Get the first matching file
        }

        if ($backup_file && file_exists($backup_file)) {
            // Move the backup file to the custom folder
            $moved_file_path = $custom_folder . '/' . basename($backup_file);

            if (rename($backup_file, $moved_file_path)) {
                // Save the backup file name to a text file
                $backup_filename_path = $custom_folder . '/backup_filename.txt';
                file_put_contents($backup_filename_path, $moved_file_path);

                return response()->json([
                    'message' => 'Backup completed successfully!',
                    'backup_file' => $moved_file_path
                ], 200);
            } else {
                return response()->json(['message' => 'Error: Failed to move the backup file.'], 500);
            }
        } else {
            return response()->json(['message' => 'Error: Backup file was not generated within the expected time.'], 404);
        }
    }
}
