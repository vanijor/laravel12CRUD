<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('dashboard');

Route::get('/index-user', [UserController::class, 'index'])->name('users.index');
Route::get('/show-user/{user}', [UserController::class, 'show'])->name('users.show');

Route::get('/create-user', [UserController::class, 'create'])->name('users.create');
Route::post('/store-user', [UserController::class, 'store'])->name('users.store');

Route::get('/edit-user/{user}', [UserController::class, 'edit'])->name('users.edit');
Route::put('/update-user/{user}', [UserController::class, 'update'])->name('users.update');

Route::get('/edit-user-password/{user}', [UserController::class, 'editPassword'])->name('users.edit-password');
Route::put('/update-user-password/{user}', [UserController::class, 'updatePassword'])->name('users.update-password');

Route::delete('/destroy-user/{user}', [UserController::class, 'destroy'])->name('users.destroy');
