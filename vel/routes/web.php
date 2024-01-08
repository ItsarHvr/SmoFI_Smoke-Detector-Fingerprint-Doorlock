<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccessLogController;
use App\Http\Controllers\SmokeDetectorController;
use App\Http\Controllers\EnrollController;
use App\Http\Controllers\GasReadingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
require __DIR__.'/auth.php';

Route::get('/', function () {
    return view('auth.login');
});

/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
*/

route::get('/home',[HomeController::class,'index'])->middleware('auth')->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/door', [DoorController::class, 'index'])->middleware(['admin'])->name('door');
    Route::post('/door/update', [DoorController::class, 'update'])->name('door.update');
    

    Route::get('/logs', [AccessLogController::class, 'index'])->name('logs');



    Route::get('/smoke', [SmokeDetectorController::class, 'index'])->name('smoke');
    Route::get('/insert-reading', [SmokeDetectorController::class, 'insertReading']);




    Route::get('/enroll', [EnrollController::class, 'index'])->middleware(['admin'])->name('enroll');;
});




