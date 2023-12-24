<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\RelayController;
use App\Http\Controllers\DataController;

Route::get('/user/create', [DataController::class, 'create'])->name('user.create');
Route::post('/user/store', [DataController::class, 'store'])->name('user.store');
Route::get('/user/login', [DataController::class, 'login'])->name('user.login');
Route::post('/user/in', [DataController::class, 'authenticate'])->name('user.in');

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
