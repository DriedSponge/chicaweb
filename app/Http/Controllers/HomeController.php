<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;
class HomeController extends Controller
{
    public function index(Request $request): \Inertia\Response
    {
        if(Auth::check()){
            $user= $request->user();
            $uploads = $request->user()->allUploads()->orderBy("created_at",'DESC')->with(['author','server'])->get();
            $ownedServers = collect($user->ownedServers()->get());

            $uploads->transform(function ($upload) use ($user,$ownedServers){
                if($upload->server->private){
                    $upload->raw_url = $upload->generateTempURL();

                }else{
                    $upload->raw_url = \Storage::url("/uploads/".$upload->fileName);
                }

                $upload->created_at_distance= $upload->created_at->diffForHumans();
                $upload->server->name= Str::limit($upload->server->name, 20);
                $upload->author->name= Str::limit($upload->author->name, 20);
                $upload->deleteable = $ownedServers->has($upload->server->id) || $user->admin ||$upload->author->name == $user->id ;
                return $upload;
            });
            return Inertia::render('Home',['uploads'=>$uploads]);
        }else{
            return Inertia::render('Home', [
                'user' => null,
                'logged_in'=>false
            ]);
        }
    }
}
