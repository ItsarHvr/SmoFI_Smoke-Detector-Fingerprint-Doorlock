<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccessLogController;
use App\Http\Controllers\SmokeDetectorController;
use App\Http\Controllers\EnrollController;
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
    Route::post('/door/update', [DoorController::class, 'update'])->name('door.update');
    

    Route::get('/logs', [AccessLogController::class, 'index'])->name('logs');



    Route::get('/smoke', [SmokeDetectorController::class, 'index'])->name('smoke');
    Route::post('/insert-gas-reading', [SmokeDetectorController::class, 'insertGasReading']);
    
    Route::get('/enroll', [EnrollController::class, 'index'])->middleware(['admin'])->name('enroll');
    Route::patch('/enroll/{id}', [EnrollControllerr::class, 'edit'])->middleware(['admin'])->name('enroll.edit');


    Route::get('/userlist', [UserListController::class, 'index'])->middleware(['admin'])->name('userlist.index');
    Route::get('/userlist/{id}/edit', [UserListController::class, 'edit'])->middleware(['admin'])->name('userlist.edit');
    Route::patch('/userlist/{id}', [UserListController::class, 'update'])->middleware(['admin'])->name('userlist.update');
    Route::delete('/userlist/{id}', [UserListController::class, 'destroy'])->middleware(['admin'])->name('userlist.destroy');
    });
    



