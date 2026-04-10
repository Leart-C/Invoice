<?php

use App\Http\Controllers\Auth\GoogleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

//public routes
Route::get('/login',function(){
    return view('auth.login');
})->name('login');
Route::get('/auth/google/redirect',[GoogleController::class,'redirect'])->name('google.redirect');
Route::get('/auth/google/callback',[GoogleController::class, 'callback'])->name('google.callback');
Route::post('/logout',[GoogleController::class, 'logout'])->name('logout');

//protected routes
Route::middleware('auth')->group(function(){
    Route::get('/dashboard',function(){
        return view('pages.dashboard');
    })->name('dashboard');
});