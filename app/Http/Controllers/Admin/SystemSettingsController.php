<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SystemSettingsController extends Controller
{
    public function index()
    {
        return view('userdashboard.admin.systemSettings.index');
    }

    public function backupData(Request $request)
    {
        try {
            // Generate a timestamped filename
            $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
            $fileName = "backup_{$timestamp}.sql";
            $path = storage_path("app/backups/{$fileName}");

            // Ensure backup directory exists
            if (!file_exists(storage_path('app/backups'))) {
                mkdir(storage_path('app/backups'), 0777, true);
            }

            // Run database dump command
            $command = sprintf(
                'mysqldump -u%s -p%s %s > %s',
                env('DB_USERNAME'),
                env('DB_PASSWORD'),
                env('DB_DATABASE'),
                $path
            );

            exec($command);

            // Optionally store in Laravel storage (e.g., for download)
            return response()->download($path);

        } catch (\Exception $e) {
            return back()->with('error', 'Backup failed: ' . $e->getMessage());
        }
    }
}
