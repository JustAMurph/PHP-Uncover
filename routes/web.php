<?php

use App\Analysis\Analysis;
use App\Http\Controllers\ApplicationsController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\NotificationSettingsController;
use App\Http\Controllers\SamplesController;
use App\Http\Controllers\ScansController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\UsersController;
use App\Plugins\Symfony\Symfony;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() {
    return redirect('/login');
});

Route::prefix('signup')
    ->controller(SignupController::class)
    ->group(function() {
        Route::get('company', 'company')->name('signup:company');
        Route::post('details', 'details')->name('signup:details');
        Route::post('store', 'store')->name('signup:store');
    });


Route::get('sample/download/{framework}', [SamplesController::class, 'download'])->name('samples:download');

Route::prefix('evaluation')
    ->controller(EvaluationController::class)
    ->group(function() {
        Route::get('', 'info')->name('evaluation');
        Route::get('download', 'download')->name('evaluation:download');
        Route::get('login', 'login')->name('evaluation:login');
    });

Route::get('/test-symfony', function () {
    $analysis = new Analysis(
        new \SplFileInfo(base_path('tests/ParsingCode/Symfony/')),
        Symfony::class
    );

    $data = [
        'vulnerabilities' => $analysis->vulnerabilities(),
        'credentials' => $analysis->credentials(),
        'settings' => $analysis->settings(),
        'entryPoints' => $analysis->entryPoints()
    ];

    return view('output/web_report', $data);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


Route::middleware('auth')->group(function() {
    Route::get('samples', [SamplesController::class, 'index'])->name('samples');

    Route::prefix('applications')
        ->controller(ApplicationsController::class)
        ->group(function() {
            Route::get('/', 'index')->name('applications');
            Route::any('/create', 'create')->name('applications:create');
            Route::get('/delete/{application}', 'delete')->name('applications:delete');
    });

    Route::prefix('scans')
        ->controller(ScansController::class)
        ->group(function() {
            Route::get('/', 'index')->name('scans');
            Route::any('/create', 'create')->name('scans:create');
            Route::post('/start', 'start')->name('scans:start');
            Route::get('/status', 'status')->name('scans:status');
            Route::get('/view/{id}', 'view')->name('scans:view');
            Route::any('/delete/{id}', 'delete')->name('scans:delete');
        });

    Route::prefix('notification-settings')
        ->controller(NotificationSettingsController::class)
        ->group(function() {
            Route::get('/', 'index')->name('notificationSettings');
            Route::get('/create', 'create')->name('notificationSettings:create');
            Route::post('/store', 'store')->name('notificationSettings:store');
            Route::post('/delete', 'delete')->name('notificationSettings:delete');
        });

    Route::prefix('notifications')
        ->controller(NotificationsController::class)
        ->group(function() {
            Route::get('/', 'index')->name('notifications');
            Route::post('/read/{notification}', 'read')->name('notifications:read');
        });

    Route::prefix('users')
        ->controller(UsersController::class)
        ->group(function() {
            Route::get('', 'index')->name('users');
            Route::get('create', 'create')->name('users:create');
            Route::post('store', 'store')->name('users:store');
            Route::post('delete', 'delete')->name('users:delete');
        });
});



require __DIR__.'/auth.php';
