<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\MonitoringController;

use Illuminate\Support\Facades\Artisan;


/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect('/login');
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (WAJIB - JANGAN DIHAPUS)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| AUTH REQUIRED
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD (1 SYSTEM)
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | TASKS (FULL)
    |--------------------------------------------------------------------------
    */
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.delete');

    Route::post('/tasks/{task}/submit', [TaskController::class, 'submit'])
        ->name('tasks.submit');

    Route::delete('/task-submissions/{submission}', [TaskController::class, 'deleteSubmission'])
        ->name('submission.delete');

    /*
    |--------------------------------------------------------------------------
    | MONITORING (FULL)
    |--------------------------------------------------------------------------
    */
    Route::get('/monitoring', [MonitoringController::class, 'index'])
        ->name('monitoring.index');

    /*
    |--------------------------------------------------------------------------
    | ATTENDANCE (FULL)
    |--------------------------------------------------------------------------
    */
    Route::post('/attendance', [AttendanceController::class, 'store'])
        ->name('attendance.store');

    Route::delete('/attendance/{id}', [AttendanceController::class, 'destroy'])
        ->name('attendance.delete');

    /*
    |--------------------------------------------------------------------------
    | PROFILE (BIAR NAV GA ERROR)
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');

    /*
    |--------------------------------------------------------------------------
    | LOGOUT (FIX FINAL)
    |--------------------------------------------------------------------------
    */
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/login');
    })->name('logout');


    /*
    |--------------------------------------------------------------------------
    | KETUA ONLY
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:ketua'])->group(function () {

        // USERS
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.delete');

        // DIVISIONS
        Route::get('/divisions', [DivisionController::class, 'index'])->name('divisions.index');
        Route::post('/divisions', [DivisionController::class, 'store'])->name('divisions.store');
        Route::post('/divisions/{division}/assign', [DivisionController::class, 'assign'])
            ->name('divisions.assign');
    });

/*
|--------------------------------------------------------------------------
| Sementara 
|--------------------------------------------------------------------------
*/

Route::get('/seed-admin', function () {
    Artisan::call('db:seed', [
        '--class' => 'AdminSeeder',
        '--force' => true
    ]);

    return 'AdminSeeder executed successfully';
});

/*
|--------------------------------------------------------------------------
| presensi
|--------------------------------------------------------------------------
*/
Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');

Route::post('/attendance/toggle', [AttendanceController::class, 'toggle'])->name('attendance.toggle');

Route::post('/attendance/session', [AttendanceController::class, 'createSession'])->name('attendance.session.create');

Route::delete('/attendance/session/{session}', [AttendanceController::class, 'deleteSession'])
    ->name('attendance.session.delete');
    
});