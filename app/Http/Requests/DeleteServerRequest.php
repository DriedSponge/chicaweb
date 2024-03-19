<?php

namespace App\Http\Requests;

use App\Models\Server;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class DeleteServerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(Request $request): bool
    {
        $server = Server::where("did",$request->server_id)->first();
        if(\Auth::user()->admin && $server || $server->owner_id == \Auth::user()->id){
            $request->merge(["server"=> $server]);
            return true;
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
