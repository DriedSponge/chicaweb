<?php

namespace App\Http\Controllers;

use App\Models\Server;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Ramsey\Uuid\Type\Integer;
use function Laravel\Prompts\error;
use function Termwind\render;

class ServerController extends Controller
{
    public function view(Request $request, $server_id)
    {
        $user = $request->user();
        $server = Server::firstWhere("did",$server_id);
        if($server){

            $server->totalPosts = $server->uploads()->count();
            $server->totalUsers = $server->users()->count();
            if($server->isSuspended()){
                return response("Not found",404);
            }



            if($server->private){
                if(!\Auth::check()){
                    return redirect()->route("loginPage");
                }else if($user->servers->contains($server)){
                    return Inertia::render("Server",["server"=>$server]);
                }else{
                    return response("Not found",404);
                }
            }

            // http://localhost/servers/343920171100012558


            return Inertia::render("Server",["server"=>$server]);
        }else {
            return response("Not found",404);
        }
    }


}
