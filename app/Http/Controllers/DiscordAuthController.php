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

        $apiResponse= Http::withToken($user->discord_token)->acceptJson()->get("https://discord.com/api/v10/users/@me/guilds")->json();
        $serverIds = collect($apiResponse)->pluck('id')->toArray();
        $existingServers = Server::whereIn('did',$serverIds)->get();
        foreach ($existingServers as $existingServer) {
            $serverData = collect($apiResponse)->firstWhere('id', $existingServer->did);
            $existingServer->name = $serverData['name'];
            $existingServer->server_icon = $serverData['icon'];
            $existingServer->save();
            if($serverData['owner'] && $existingServer->owner_id != $user->id){
                $existingServer->owner()->associate($user);
                $existingServer->save();
            }
        }

        $newServers = collect($apiResponse)->whereNotIn('id', $existingServers->pluck('did')->toArray());
        foreach ($newServers as $newServer) {
            $inServer = Http::withHeader("Authorization","Bot " . config("services.discord.bot_secret"))->acceptJson()->get("https://discord.com/api/v10/guilds/".$newServer['id']."/members/".config("services.discord.client_id"));
            $getServer = new Server();
            $getServer->did = $newServer['id'];
            $getServer->name = $newServer['name'];
            $getServer->server_icon = $newServer['icon'];
            if($newServer['owner']){
                $getServer->owner()->associate($user);
            }
            if($inServer->clientError() || $inServer->serverError()){
                if($newServer['owner']){
                    $getServer->botIn = false;
                    $getServer->save();
                }else{
                    continue;
                };
            }
            $getServer->save();

        }

        $user->servers()->sync(Server::whereIn("did",$serverIds)->get());
        Auth::login($user);
        return redirect('/');
    }
}
