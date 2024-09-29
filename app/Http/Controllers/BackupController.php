<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

class BackupController extends Controller
{
    public function initiateBackup()
    {
        $currentDirectoryPath = base_path();
		
		$cpanelUsername = env('CPANEL_USERNAME'); // Get from .env
        $apiToken = env('CPANEL_API_TOKEN'); // Get from .env
        $cpanelMainDomain = env('CPANEL_MAIN_DOMAIN'); // Get from .env
		
        $uapiUrl = "https://{$cpanelMainDomain}:2083/json-api/cpanel";
        $customFolder = $currentDirectoryPath . '/backups';

        // Ensure the backup folder exists
        if (!File::exists($customFolder)) {
            File::makeDirectory($customFolder, 0755, true);
        }

        $query = http_build_query([
            'cpanel_jsonapi_user' => $cpanelUsername,
            'cpanel_jsonapi_apiversion' => '3',
            'cpanel_jsonapi_module' => 'Backup',
            'cpanel_jsonapi_func' => 'fullbackup_to_homedir',
        ]);

        $fullUrl = "{$uapiUrl}?{$query}";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $fullUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification if necessary
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: cpanel {$cpanelUsername}:{$apiToken}"
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            return response()->json(['error' => 'cURL Error: ' . curl_error($ch)], 500);
        } else {
            $result = json_decode($response, true);
            if ($result && isset($result['result']['status']) && $result['result']['status'] === 1) {
                return response()->json(['message' => 'Backup initiated successfully!', 'pid' => $result['result']['data']['pid']]);
            } else {
                return response()->json(['error' => 'Backup initiation failed', 'response' => $result], 500);
            }
        }

        curl_close($ch);
    }
}
