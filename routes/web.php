<?php

use App\Http\Middleware\Authenticate;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
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



Route::middleware(Authenticate::class)->group(function (){
    // Basic viewing
    Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name("home");
    Route::get('/servers', [\App\Http\Controllers\BrowseController::class, 'servers'])->name("servers");

    // Server Settings
    Route::middleware(\App\Http\Middleware\ServerManager::class)->group(function (){
        Route::get('/servers/{server}/settings', [\App\Http\Controllers\ServerController::class, 'serverSettings'])->name("server.settings");
    });

    Route::put('/servers/{server}/settings', [\App\Http\Controllers\ServerController::class, 'saveSettings'])->middleware([HandlePrecognitiveRequests::class])->name("server.settings.save");
    Route::delete('/servers/{server}', [\App\Http\Controllers\ServerController::class, 'deleteServer'])->middleware([HandlePrecognitiveRequests::class])->name("server.delete");


    // Post Settings

    Route::get("/servers/{server_id}/posts/{post_id}", [\App\Http\Controllers\PostController::class, 'view'])->name("post");

});


//Servers
Route::get('/servers/{server}', [\App\Http\Controllers\ServerController::class, 'view'])->name("server");





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
