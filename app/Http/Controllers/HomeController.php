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
            return Inertia::render('Home', [
                'user' => $request->user(),
                'servers'=>$request->user()->servers()->get(),
                'logged_in'=>true
            ]);
        }else{
            return Inertia::render('Home', [
                'user' => null,
                'logged_in'=>false
            ]);
        }
    }
}
