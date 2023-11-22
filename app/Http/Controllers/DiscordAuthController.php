<?php

namespace App\Http\Controllers;

use App\Models\Server;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;
class DiscordAuthController extends Controller
{
    public function auth()
    {
        $callbackUser = Socialite::driver('discord')->user();
        $userExists = User::where('id', $callbackUser->id)->first();
        if($userExists){
            $userExists->discord_token = $callbackUser->token;
            $userExists->name = $callbackUser->name;
            $userExists->avatar = $callbackUser->avatar;
            $userExists->save();
            Auth::login($userExists);
        }else{
            $newUser = new User();
            $newUser->id = $callbackUser->id;
            $newUser->discord_token = $callbackUser->token;
            $newUser->name = $callbackUser->name;
            $newUser->avatar = $callbackUser->avatar;
            $newUser->save();
            Auth::login($newUser);
        }
        $user = Auth::user()->with('servers')->first();
        // TODO: Instead of detaching all the servers and retaching them, just loop to see which ones
        // In the db are no longer in the API response.
        // Update Users Servers
        $servers = Http::withToken($user->discord_token)->acceptJson()->get("https://discord.com/api/v10/users/@me/guilds")->json();
        collect($servers)->map(function ($server) use ($user){
            $serverExists = Server::where('id', $server['id'])->first();
                if($serverExists){
                    $serverExists->name = $server['name'];
                    $serverExists->server_icon = $server['icon'];
                    $serverExists->save();
                    if($user->servers()->where('server_id',$serverExists->id)->count() == 0){
                        $user->servers()->attach($serverExists->id, ['is_owner'=>$server["owner"]]);
                    }
                }else{
                    // Check if in server using discord API.
                    $inServer = Http::withHeader("Authorization","Bot " . config("services.discord.bot_secret"))->acceptJson()->get("https://discord.com/api/v10/guilds/".$server['id']."/members/".config("services.discord.bot_userid"));
                    if(!$inServer->clientError()){
                        $newServer = new Server();
                        $newServer->id = $server['id'];
                        $newServer->name = $server['name'];
                        $newServer->server_icon = $server['icon'];
                        $newServer->save();
                        $user->servers()->attach($newServer->id, ['is_owner'=>$server["owner"]]);
                    }
                }

        });
        return redirect('/');
    }
}
