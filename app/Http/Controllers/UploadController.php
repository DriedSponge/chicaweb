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
                return response(["error"=>"Error fetching Discord api data!"],500);
            }
            $server = Server::where("id", $server_id)->first();
            if (!$server) {
                $server = new Server();
                $server->id = $server_id;
                $server->name=$getServer->json()["name"];
                $server->server_icon = $getServer->json()['icon'];
                $server->save();
                return response(["Error fetching Discord api data!", 500]);
            }
            $validator = Validator::make($request->all(),[
                'user_id' => 'required|string',
                'user_name' => 'string|required',
                'user_avatar' => 'required|url',
                'file' => ['required', File::types(["image/jpg", "image/jpeg", "image/png", "image/gif"])->max("100mb")]
            ]);
            if($validator->passes()){
                $user = User::firstOrNew(['id'=>$request->user_id],['id'=>$request->user_id]);
                $user->name = $request->user_name;
                $user->avatar = $request->user_avatar;
                $user->save();
                $user->servers()->syncWithoutDetaching([$server->id => ['is_owner' => $user->id == $getServer['owner_id']]]);
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
