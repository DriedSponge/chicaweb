<?php

namespace App\Http\Requests;

use App\Models\Server;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class DeleteServerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request. Please put behind
     * Authorize middleware.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     */
    public function rules(Request $request, Server $server): array
    {
        $serverName = $request->route("server")->name;
        return [
            "server_name"=>"required|string|in:".$serverName
        ];
    }
}
