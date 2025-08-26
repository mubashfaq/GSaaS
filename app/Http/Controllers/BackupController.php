<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Carbon\Carbon;
use Illuminate\Console\Command;
use DateTime;
class BackupController extends Controller
{
    public function backupCode()
    {
       
        try {
            // Define backup paths
            $backupPath = base_path('Backup');
            $backupFile = $backupPath . '/backup_' . date('Y-m-d_H-i-s') . '.zip';

            // Ensure the backup directory exists
            if (!file_exists($backupPath)) {
                mkdir($backupPath, 0755, true);
            }
             $this->deleteOldBackups($backupPath);
            // Create a zip archive for the backup
            $zip = new ZipArchive;
            if ($zip->open($backupFile, ZipArchive::CREATE) === TRUE) {
                // Add project files to the backup
                $this->addProjectFilesToZip($zip, base_path());

                // Add database dump to the backup
                $dbDumpFile = $backupPath . '/database_dump.sql';
                $this->backupDatabase1($dbDumpFile);
                $zip->addFile($dbDumpFile, 'database_dump.sql');
                
                // Close the zip file
                $zip->close();

                // Delete the temporary database dump file
                unlink($dbDumpFile);

                return response()->json(['status' => 'success', 'message' => 'Backup created successfully.'], 200);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Could not create the backup archive.'], 500);
            }

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Failed to create backup: ' . $e->getMessage()], 500);
        }
    }

    // Method to add project files to the zip
    protected function addProjectFilesToZip($zip, $path, $basePath = null)
    {
        $files = scandir($path);

        foreach ($files as $file) {
            if ($file == '.' || $file == '..' || $file == 'Backup' || $file == 'dev.gsaas.com.au' ) {
                continue;
            }

            $filePath = $path . DIRECTORY_SEPARATOR . $file;
            $relativePath = $basePath ? $basePath . DIRECTORY_SEPARATOR . $file : $file;

            if (is_dir($filePath)) {
                $this->addProjectFilesToZip($zip, $filePath, $relativePath);
            } else {
                $zip->addFile($filePath, $relativePath);
            }
        }
    }
    protected function backupDatabase1($dbDumpFile)
    {
        $databaseName = "gsaas_live";
        $username = "gsaas_live";
        $password = "rZaSR$&;;,cm";
        $host = "127.0.0.1";
        
        // Execute mysqldump command
        $command = sprintf(
            'mysqldump --user=%s --password=%s --host=%s %s > %s',
            escapeshellarg($username),
            escapeshellarg($password),
            escapeshellarg($host),
            escapeshellarg($databaseName),
            escapeshellarg($dbDumpFile)
        );

        exec($command);
    }
    //   'C:\\xampp\\mysql\\bin\\mysqldump --user=%s --password=%s --host=%s %s > %s',
    protected function deleteOldBackups($backupPath)
    {
        $sevenDaysAgo = strtotime('-2 days');
        $files = scandir($backupPath);
    
        foreach ($files as $file) {
            // Skip if it's not a backup file
            if (pathinfo($file, PATHINFO_EXTENSION) != 'zip') {
                continue;
            }
    
            // Extract date from the filename (assuming format: backup_YYYY-MM-DD_HH-MM-SS.zip)
            if (preg_match('/backup_(\d{4}-\d{2}-\d{2})_\d{2}-\d{2}-\d{2}\.zip$/', $file, $matches)) {
                $fileDate = $matches[1];
                $fileTimestamp = strtotime($fileDate);
    
                // Delete the file if it's older than 7 days
                if ($fileTimestamp < $sevenDaysAgo) {
                    unlink($backupPath . DIRECTORY_SEPARATOR . $file);
                }
            }
        }
    }

}
