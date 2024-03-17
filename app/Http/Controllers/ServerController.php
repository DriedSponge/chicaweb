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
            $canLeave = false;
            $own=false;
            $canEdit = false;
            if($user){
                $canLeave = $server->users()->where("user_id", $user->id)->exists();
                $own = $server->owner()->exists() && $server->owner()->first()->id == $user->id;
                $canEdit=$user->admin || $own;
            }
            return Inertia::render("Server",["server"=>$server,'joined'=>$canLeave,'canEdit'=>$canEdit]);
        }else {
            return response("Not found",404);
        }
    }


}
