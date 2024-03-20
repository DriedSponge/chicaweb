<?php

namespace App\Http\Requests;

use App\Models\Server;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class SaveServerSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(Request $request): bool
    {
        if(\Auth::check()){
            $server = $request->route("server");
            $user = \Auth::user();
            if($server->owner_id == $user->id || $user->admin){
                if($user->admin || !$server->isSuspended()){
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "private"=>"required|boolean"
        ];
    }
}
