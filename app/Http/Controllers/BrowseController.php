<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class BrowseController extends Controller
{
    public function servers(Request $request)
    {
        if(Auth::check()){
            //dd($request->user()->servers()->get());
            return Inertia::render('Servers', ['servers'=>$request->user()->servers()->get()]);
        }else{
            return redirect("/");
        }
    }
}
