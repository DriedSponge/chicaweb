<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;
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

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name("home");
Route::get('/servers', [\App\Http\Controllers\BrowseController::class, 'servers'])->middleware(\App\Http\Middleware\Authenticate::class)->name("servers");


// Auth
Route::get("/auth/discord", function (){
    return Socialite::driver('discord')->setScopes(['identify','guilds'])->redirect();
})->name('login');

Route::get('/auth/discord/callback',  [\App\Http\Controllers\DiscordAuthController::class, 'auth']);
Route::get('/logout', function (){
    Auth::logout();
    return redirect('/');
})->name("logout");
