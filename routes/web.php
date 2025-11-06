<?php

use App\Http\Controllers\WebController;
use Illuminate\Console\View\Components\Warn;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login.page');
});


Route::get('/register',[WebController::class,'showRegister'])->name('register');
Route::get('/login',[WebController::class,'showLogin'])->name('login');


Route::post('/login-now',[WebController::class,'login'])->name('login.now');
Route::post('/signup-now',[WebController::class,'register'])->name('signup.now');

Route::middleware('auth')->group(function(){
    Route::get('/dashboard',function(){
        return view('dashboard');
    })->name('dashboard');
    Route::get('/blog',[WebController::class,'blogShow'])->name('blog.view');
    Route::get('/logout',function(){
      Auth::logout();
      return redirect()->route('login');
    })->name('logout');
});
