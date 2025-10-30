<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

// Route::get('/documentation-attendance-device-addon', function() {
//     return File::get(public_path() . '/documentation/attendance_device_addon/index.php');
// });

Route::get('/phpinfo', function() {
    return phpinfo();
});

Route::get('/documentation-attendance-device-addon', function() {
    return view('documentation.attendance_device_addon.index');
});

Route::get('/optimize', function() {
    Cache::flush();
    Artisan::call('optimize:clear');
    return redirect()->back();
});


Route::get('/migrate-central', function() {
    Artisan::call('migrate --path=database/migrations/landlord');
    return 'Successfully Migrated';
});

Route::get('/db-seed-central', function() {
    // Artisan::call('db:seed --class=NameSeeder');
    Artisan::call('db:seed');
    return 'DB Seeding Successfully';
});

Route::get('/maintainance-down', function() {
    Artisan::call('down');
    return redirect()->back();
});

Route::get('/maintainance-up', function() {
    Artisan::call('up');
    return redirect()->back();
});

Route::get('/optimize-spatie-permission', function() {
    Artisan::call('cache:clear');
    Artisan::call('cache:forget spatie.permission.cache');
    return redirect()->back();
});


