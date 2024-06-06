<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogingController;
use App\Http\Controllers\MusicController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('login',[LogingController::class,'index'])->name('login');
Route::post('login',[LogingController::class,'login'])->name('loginSubmited');

Route::middleware('login')->group(function(){
    Route::get('',[HomeController::class,'index'])->name('home');

    Route::post('/Music_Timer',[MusicController::class,'form'])->name('music.timer.Post');
    Route::get('/Music_Timer',[MusicController::class,'index'])->name('music.timer');

});

