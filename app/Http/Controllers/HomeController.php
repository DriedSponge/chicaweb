<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
class HomeController extends Controller
{
    public function index(Request $request): \Inertia\Response
    {
        if(Auth::check()){
            $uploads = $request->user()->allUploads()->orderBy("created_at",'DESC')->with(['author','server'])->get();
            $uploads->transform(function ($upload){
                $upload->raw_url = \Storage::url("/uploads/".$upload->fileName);
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
