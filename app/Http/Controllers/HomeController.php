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

            $uploads->transform(function ($upload) use ($user){
                if($upload->server->private){
                    $upload->raw_url = $upload->generateTempURL();
                }else{
                    $upload->raw_url = \Storage::url($upload->path());
                }

                $upload->created_at_distance= $upload->created_at->diffForHumans();
                $upload->server->name= Str::limit($upload->server->name, 20);
                $upload->author->name= Str::limit($upload->author->name, 20);
                $upload->deleteable = $upload->server->owner_id == $user->id || $user->admin ||$upload->author->id == $user->id ;
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
