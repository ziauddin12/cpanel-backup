<?php
namespace App\Http\Controllers;

use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Illuminate\Support\Facades\File;

class GoogleDriveController extends Controller
{
    public function uploadGoogleDrive()
    {
        // Current directory path
        $current_directory_path = base_path(); // Laravel base path

        // Your cPanel username
		$cpanel_username = env('CPANEL_USERNAME');

        // Custom folder for backup
        $custom_folder = $current_directory_path . '/backups';


        // Pattern to match the expected backup file name
        $backup_pattern = $custom_folder . '/backup-' . date('n.j.Y') . '_*.tar.gz';

        // Check for the backup file
        $files = glob($backup_pattern);
        $backup_file = null;
        if (!empty($files)) {
            $backup_file = $files[0]; // Get the first matching file
        }

        if ($backup_file && file_exists($backup_file)) {
            // Proceed with Google Drive upload
            $backup_file_path = $backup_file;
			
			 $driveBackupFilePath = base_path(env('DRIVE_BACKUP_FILE'));

            // Google API Client Setup
            putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $driveBackupFilePath);

            $client = new Google_Client();
            $client->useApplicationDefaultCredentials();
            $client->addScope(Google_Service_Drive::DRIVE);

            $service = new Google_Service_Drive($client);

            // Prepare file for upload
            $fileMetadata = new Google_Service_Drive_DriveFile([
                'name' => basename($backup_file_path)
            ]);

            $content = file_get_contents($backup_file_path);

            // Upload to Google Drive
            $file = $service->files->create($fileMetadata, [
                'data' => $content,
                'mimeType' => 'application/gzip',
                'uploadType' => 'multipart',
                'fields' => 'id',
            ]);

            return response()->json([
                'message' => 'Backup file uploaded successfully!',
                'file_id' => $file->id,
            ], 200);
        } else {
            return response()->json(['message' => 'Error: Backup file was not generated or found.'], 404);
        }
    }
}
