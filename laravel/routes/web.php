<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccessLogController;
use App\Http\Controllers\SmokeDetectorController;
use App\Http\Controllers\EnrollController;
use App\Http\Controllers\GasReadingController;
use App\Http\Controllers\UserListController;

require __DIR__.'/auth.php';

Route::get('/', function () {
    return view('auth.login');
});

route::get('/home',[HomeController::class,'index'])->middleware('auth')->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/door', [DoorController::class, 'index'])->middleware(['admin'])->name('door');
    Route::get('/door-json', [DoorController::class, 'getStatusRelayJson'])->name('relay.status.json');
    Route::post('/door-update', [DoorController::class, 'perbaruiStatusRelay']);
    
    Route::get('/logs', [AccessLogController::class, 'showLogs'])->name('logs');

    Route::get('/smoke-detector', [SmokeDetectorController::class, 'index'])->name('smoke');

    Route::get('/userlist', [UserListController::class, 'index'])->middleware(['admin'])->name('userlist.index');
    Route::get('/userlist/{id}/edit', [UserListController::class, 'edit'])->middleware(['admin'])->name('userlist.edit');
    Route::patch('/userlist/{id}', [UserListController::class, 'update'])->middleware(['admin'])->name('userlist.update');
    Route::delete('/userlist/{id}', [UserListController::class, 'destroy'])->middleware(['admin'])->name('userlist.destroy');

    Route::get('/enroll/{id}', [EnrollController::class, 'enroll'])->middleware(['admin'])->name('enroll.enroll');
    Route::patch('/enroll/{id}', [EnrollController::class, 'enroll_id'])->middleware(['admin'])->name('enroll.update');

});
    
Route::get('/api/log-access', [AccessLogController::class, 'getLogAccessData']);
Route::get('/api/smoke-value', [SmokeDetectorController::class, 'getSmokeValueData']);

Route::get('/send-event', function(){
    $pesan = "tes";
    broadcast(new \App\Events\HelloEvent($pesan));
});

Route::get('/send-log', function(){
    $updatedLogAccess = [
        'user_name' => 'kiki',
        'fingerprint_id' => '1',
        'access_date' => '2024-01-17',
        'access_time' => '13:30:30',
        'access' => 'Granted',
    ];

    \App\Models\LogAccess::create($updatedLogAccess);
    
    broadcast(new \App\Events\LogAccessEvent($updatedLogAccess));
});

Route::get('/send-paginate', function(){
    $updatedLogAccess = [
        'user_name' => 'kiki',
        'fingerprint_id' => '1',
        'access_date' => '2024-01-17',
        'access_time' => '13:30:30',
        'access' => 'Granted',
    ];

    \App\Models\LogAccess::create($updatedLogAccess);
    $updatePaginate = 14;
    
    broadcast(new \App\Events\LogAccessEvent($updatedLogAccess, $updatePaginate, request()->page));
});

use App\Http\Controllers\TestController;

Route::get('/test-log-access', [TestController::class, 'testLogAccess']);

Route::get('/send-smoke', function(){
    $text = 2000;
    broadcast(new \App\Events\SmokeEvent($text));
});




