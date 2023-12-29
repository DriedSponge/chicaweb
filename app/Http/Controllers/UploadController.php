<?php

namespace App\Http\Controllers;

use App\Models\Server;
use App\Models\Upload;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules\File;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

class UploadController extends Controller
{
    public function upload(Request $request, string $server_id)
    {
        if ($request->bearerToken() == config("app.interaction_key")) {

            // Create a sever if it does not exist
            $getServer = Http::withHeader("Authorization","Bot " . config("services.discord.bot_secret"))->acceptJson()->get("https://discord.com/api/v10/guilds/".$server_id);
            if($getServer->clientError() || $getServer->serverError()) {
                return response(["error"=>"Error fetching Discord api data! The bot might not be in the server."],500);
            }
            $server = Server::firstOrNew(['did'=>$server_id],['did'=>$server_id]);
            $server->did = $server_id;
            $server->name=$getServer->json()["name"];
            $server->server_icon = $getServer->json()['icon'];
            $server->save();
            $validator = Validator::make($request->all(),[
                'user_id' => 'required|string',
                'user_name' => 'string|required',
                'user_avatar' => 'required|url',
                'file' => ['required', File::types(["image/jpg", "image/jpeg", "image/png", "image/gif"])->max("100mb")]
            ]);
            if($validator->passes()){
                $user = User::firstOrNew(['did'=>$request->user_id],['did'=>$request->user_id]);
                $user->did = $request->user_id;
                $user->name = $request->user_name;
                $user->avatar = $request->user_avatar;
                $user->save();
                $user->servers()->syncWithoutDetaching($server->id);
                if($user->did == $getServer['owner_id']){
                    $server->owner()->associate($user)->save();
                }
                $upload = new Upload();
                $upload->fileName = $request->file('file')->hashName();
                $upload->save();
                $server->uploads()->save($upload);
                $user->uploads()->save($upload);
                $request->file('file')->storePublicly('uploads');
                return response(['directUrl'=>'test',"rawUrl"=>\Storage::url('uploads/'.$request->file('file')->hashName())],201);
            }else{
                return response($validator->errors(),400);
            }
        } else {
            return response(["error" => "Invalid Interaction Key!"], 401);
        }
    }
}
