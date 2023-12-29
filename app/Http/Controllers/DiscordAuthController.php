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
        $user = User::firstOrNew(['did'=>$callbackUser->id],['did'=>$callbackUser->id]);
        $user->did = $callbackUser->id;
        $user->discord_token = $callbackUser->token;
        $user->name = $callbackUser->name;
        $user->avatar = $callbackUser->avatar;
        $user->save();
        Auth::login($user);
        $servers = Http::withToken($user->discord_token)->acceptJson()->get("https://discord.com/api/v10/users/@me/guilds")->json();
        collect($servers)->map(function ($server) use ($user){
            $serverExists = Server::where('did', $server['id'])->first();
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
                        $newServer->did = $server['id'];
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
