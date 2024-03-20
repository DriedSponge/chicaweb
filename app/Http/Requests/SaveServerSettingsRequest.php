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
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return
     */
    public function rules(): array
    {
        return [
            "private"=>"required|boolean"
        ];
    }
}
