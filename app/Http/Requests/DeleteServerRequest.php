<?php

namespace App\Http\Requests;

use App\Models\Server;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use const http\Client\Curl\AUTH_ANY;

class DeleteServerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request. Please put behind
     * Authorize middleware.
     */
    public function authorize(Request $request): bool
    {
        $server = Server::where("did",$request->server_id)->first();
        if($server && \Auth::check()){
            $user = \Auth::user();
            if($server->owner_id == $user->id || $user->admin){
                if($user->admin || !$server->isSuspended()){
                    $request->merge(["server"=> $server]);
                    return true;
                }
                return false;
            }
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     */
    public function rules(Request $request): array
    {
        $serverName = $request["server"]->name;
        return [
            "server_name"=>"required|string|in:".$serverName
        ];
    }
}
