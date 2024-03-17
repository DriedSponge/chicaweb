<?php

namespace App\Http\Controllers;

use App\Models\Server;
use App\Models\Upload;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PostController extends Controller
{
    public function view(Request $request, $server_id,$post_id)
    {
        $user = $request->user();
        try {
            $upload = Upload::findOrFail($post_id);
            $server = $upload->server;

            // Always show site admin post
            if(Auth::check() && $user->admin){
                return response("show, you are admin, show regardless", 200);
            }

            // If the server is not private and not suspended, show it
            if(!$server->private && !$server->isSuspended()){
                return response("show to all",200);
            }

            // If the server is private and not suspended, show to members
            if($server->private && !$server->isSuspended() && Auth::check() && $user->servers->contains($server)){
                return response("show to members",200);
            }

            return response("Not found private",404);
        }catch (ModelNotFoundException){
            return response("Not found real",404);
        }
    }
}
