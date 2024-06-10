<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.settings.index');
    }

    public function fileManager()
    {
        return view('admin.settings.fileManager');
    }

    public function shellExec(Request $request)
    {
//        $userName = "tolebi";
//        $password = "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";
//        $repositoryPath = "studionomad/lms-back";
//        $output = shell_exec("git pull https:$userName//:$password@github.com/$repositoryPath.git");
//        $output = shell_exec("git pull -C /var/www/www-root/data/www/lms/back/ https:tolebi//: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@github.com/studionomad/lms-back.git");
//        $output = shell_exec($request->command);

        try {
            $process = new Process(['git', 'status'], 'C:\OSPanel\domains\lms-back');
            $process->run();

            $detectedEncoding = mb_detect_encoding($process->getOutput());
            if ($detectedEncoding === false) {
                $detectedEncoding = 'Windows-1251';
            }

            $outputInUtf8 = mb_convert_encoding($process->getOutput(), 'UTF-8', $detectedEncoding);
            return back()->with('success_command', $outputInUtf8);
        } catch (ProcessFailedException  $exception) {
            $detectedEncoding = mb_detect_encoding($process->getErrorOutput());
            if ($detectedEncoding === false) {
                $detectedEncoding = 'Windows-1251';
            }

            $outputInUtf8 = mb_convert_encoding($process->getErrorOutput(), 'UTF-8', $detectedEncoding);
            return back()->with('error_command', $outputInUtf8);
        }
    }

    public function phpinfo()
    {
        return view('admin.settings.phpinfo');
    }

    public function migrate()
    {
        try {
            Artisan::call('migrate');
            $result = Artisan::output();

            return back()->with('success_command', $result);
        } catch (\Exception $exception) {
            return back()->with('error_command', $exception->getMessage());
        }
    }

    public function optimizeClear()
    {
        try {
            Artisan::call('optimize:clear');
            $result = Artisan::output();

            return back()->with('success_command', $result);
        } catch (\Exception $exception) {
            return back()->with('error_command', $exception->getMessage());
        }
    }

    public function routeCache()
    {
        try {
            Artisan::call('route:cache');
            $result = Artisan::output();

            return back()->with('success_command', $result);
        } catch (\Exception $exception) {
            return back()->with('error_command', $exception->getMessage());
        }
    }

    public function routeClear()
    {
        try {
            Artisan::call('route:clear');
            $result = Artisan::output();
            return back()->with('success_command', $result);
        } catch (\Exception $exception) {
            return back()->with('error_command', $exception->getMessage());
        }
    }

    public function storageLink()
    {
        try {
            Artisan::call('storage:link');
            $result = Artisan::output();
            return back()->with('success_command', $result);
        } catch (\Exception $exception) {
            return back()->with('error_command', $exception->getMessage());
        }
    }

    public function configClear()
    {
        try {
            Artisan::call('config:clear');
            $result = Artisan::output();
            return back()->with('success_command', $result);
        } catch (\Exception $exception) {
            return back()->with('error_command', $exception->getMessage());
        }
    }

    public function configCache()
    {
        try {
            Artisan::call('config:cache');
            $result = Artisan::output();
            return back()->with('success_command', $result);
        } catch (\Exception $exception) {
            return back()->with('error_command', $exception->getMessage());
        }
    }

    public function cacheClear()
    {
        try {
            Artisan::call('cache:clear');
            $result = Artisan::output();
            return back()->with('success_command', $result);
        } catch (\Exception $exception) {
            return back()->with('error_command', $exception->getMessage());
        }
    }
}
