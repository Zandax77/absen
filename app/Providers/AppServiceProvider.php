<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            if (Schema::hasTable('settings')) {
                $schoolName = Setting::get('school_name', 'SMKN 6 JEMBER');
                $schoolLogo = Setting::get('school_logo', 'images/logo_smk6.png');
                $appTitle   = Setting::get('app_title', 'Aplikasi Pencatat Kehadiran Siswa Kelas');

                View::share([
                    'school_name' => $schoolName,
                    'school_logo' => $schoolLogo,
                    'app_title'   => $appTitle,
                ]);
            }
        } catch (\Throwable $e) {
            // Suppress error if DB not ready
        }
    }
}
