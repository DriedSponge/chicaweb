<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveServerSettingsRequest;
use App\Jobs\UpdatePrivacy;
use App\Models\Server;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Ramsey\Uuid\Type\Integer;
use stdClass;
use function Laravel\Prompts\error;
use function Termwind\render;

class ServerController extends Controller
{
    public function view(Request $request, $server_id)
    {
        $user = $request->user();
        $server = Server::where("did",$server_id)->with("owner")->first();
        if($server){
            if($server->isSuspended() && (\Auth::check() && !$user->admin)){
                return response("Not found",404);
            }

            $server->totalPosts = $server->uploads()->count();
            $server->totalUsers = $server->users()->count();

            $userPerms = new stdClass();
            if(\Auth::check()){
                $userPerms->canLeave= $server->owner?->id != $user->id && $user->servers()->where("did",$server_id)->exists();
                $userPerms->canEdit = $server->owner?->id == $user->id || $user->admin;
            }else{
                $userPerms->canLeave=false;
                $userPerms->canEdit=false;
            }

            $server->makeHidden("owner");

            if($server->private){
                if(!\Auth::check()){
                    return redirect()->route("loginPage");
                }else if($user->servers->contains($server)){
                    return Inertia::render("Server",["server"=>$server,"perms"=>$userPerms]);
                }else{
                    return response("Not found",404);
                }
            }

            // http://localhost/servers/343920171100012558


            return Inertia::render("Server",["server"=>$server,"perms"=>$userPerms]);
        }else {
            return response("Not found",404);
        }
    }
    public function serverSettings(Request $request,$server_id){
        $server = Server::where("did",$server_id)->first();
        if(!$server){
            return response(404,404);
        }
        return Inertia::render("ServerSettings",["server"=>$server]);

    }
    public function saveSettings(SaveServerSettingsRequest $request,$server_id){
        $server = Server::where("did",$server_id)->first();
        UpdatePrivacy::dispatch($server);
        $server->private=$request->validated()["private"];
        $server->save();
        return redirect(route("server.settings",["server_id"=>$server_id]));
    }

}
