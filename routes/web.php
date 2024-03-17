<?php

use App\Http\Middleware\Authenticate;
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

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->middleware(Authenticate::class)->name("home");
Route::get('/servers', [\App\Http\Controllers\BrowseController::class, 'servers'])->middleware(Authenticate::class)->name("servers");

Route::get('/servers/{server_id}', [\App\Http\Controllers\ServerController::class, 'view'])->name("server");


Route::get("/servers/{server_id}/posts/{post_id}", [\App\Http\Controllers\PostController::class, 'view'])->name("post");

// Auth
Route::get("/auth/discord", function (){
    return Socialite::driver('discord')->setScopes(['identify','guilds'])->redirect();
})->name('login');


Route::get('/login',function (){
    return Inertia::render('Login');
})->name("loginPage");
Route::get('/auth/discord/callback',  [\App\Http\Controllers\DiscordAuthController::class, 'auth']);
Route::get('/logout', function (){
    Auth::logout();
    return redirect('/');
})->name("logout");
