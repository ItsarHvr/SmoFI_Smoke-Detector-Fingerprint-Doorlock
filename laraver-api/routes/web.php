<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\RelayController;
use App\Http\Controllers\DataController;

Route::get('/user/create', [DataController::class, 'create'])->name('user.create');
Route::post('/user/store', [DataController::class, 'store'])->name('user.store');
Route::get('/user/login', [DataController::class, 'login'])->name('user.login');
Route::post('/user/in', [DataController::class, 'authenticate'])->name('user.in');
Route::get('/user/index', [DataController::class, 'index'])->name('user.index');
Route::match(['get', 'post'], '/user/logout', [DataController::class, 'logout'])->name('user.logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/user/profile', [DataController::class, 'profile'])->name('user.profile');
    Route::get('/user/edit-profile', [DataController::class, 'editProfile'])->name('user.edit.profile');
    Route::post('/user/update-profile', [DataController::class, 'updateProfile'])->name('user.update.profile');
});

Route::get('/status-relay-json', [RelayController::class, 'getStatusRelayJson'])->name('relay.status.json');
Route::get('/status-relay', [RelayController::class, 'getStatusRelay'])->name('relay.status');
Route::post('/perbarui-status-relay', [RelayController::class, 'perbaruiStatusRelay']);


Route::get('/posts/create', function () {
    return view('api.posts.create');
});

Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

Route::get('/', function () {
    return view('welcome');
});
