<?php

namespace App\Http\Middleware;

use App\Models\Server;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServerManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(\Auth::check()){
            $server=$request->route("server");
            $user = $request->user();
            if($server->owner_id = $user->id || $user->admin){
                return $next($request);
            }
            if($request->expectsJson()){
                return response()->json(["error"=>"Unauthorized"],403);
            }else{
                abort(403);
            }
        }else{
            if($request->expectsJson()) {
                return response()->json(["error" => "Unauthenticated"], 401);
            }else{
                return response()->redirectTo(route("loginPage"));
            }
        }
    }
}
