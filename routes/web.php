<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/edukasi', function () {
    return view('edukasi');
});

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

/*
|-----------------------
| LOGIN
|-----------------------
*/
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

/*
|-----------------------
| REGISTER
|-----------------------
*/
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

 Route::get('/skrining', function () {
    return view('skrining.index');
})->name('skrining.index');

Route::get('/skrining/pilih-tes', function () {
    return view('skrining.pilih-tes');
})->name('skrining.pilih-tes');
Route::get('/skrining/anxiety', function () {
    return view('skrining.anxiety');
})->name('skrining.anxiety');

Route::get('/konsultasi', function () {
    return view('konsultasi.index');
})->name('konsultasi.index');

Route::get('/pemantauan', function () {
    return view('pemantauan.index');
})->name('pemantauan.index');