<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DemoAutoUpdateController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('is-update-available', [DemoAutoUpdateController::class, 'isUpdateAvailable'])->name('is-update-available');

// Below code is deprecated, this code is needed for the client version 1.5.0 and below
Route::get('fetch-data-upgrade', function () {
    $data = null;
    $json_file = '{"files":[{"file_name":"version_upgrade.zip"}],"logs":[{"text":"Data Updated"}]}';
    $data = json_decode($json_file);
    return response()->json($data,201);
});

Route::get('fetch-data-general', function () {
    $data = [
        'general' => [
            'demo_version' => env('VERSION'),
            'product_mode' => 'DEMO',
            'demo_bug_no' => '1500',
            'minimum_required_version' => env('MINIMUM_REQUIRED_VERSION'),
            'latest_version_db_migrate_enable' => false,
            'latest_version_upgrade_enable' => true,
            'bug_update_enable' => false,
            ]
        ];
    return response()->json($data,201);
});
// Below code is deprecated, this code is needed for the client version 1.5.0 and below
