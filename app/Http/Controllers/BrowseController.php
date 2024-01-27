<?php

namespace App\Http\Controllers;

use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class BrowseController extends Controller
{
    public function servers(Request $request)
    {
        if(Auth::check()){
            $servers = $request->user()->servers()->with(['suspension'=>function ($query) {
                $query->where('active','true');
            }])->get()->reject(function (Server $server) {
                return $server->suspension->isNotEmpty();
            });
            return Inertia::render('Servers', ['servers'=>$servers]);
        }else{
            return redirect("/");
        }
    }
}
