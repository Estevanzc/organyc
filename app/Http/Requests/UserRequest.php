<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        $is_update = request()->isMethod("PUT");
        $rules = [
            "name" => ["required", "min:5", "max:25"],
            "email" => ["required", "email"],
        ];
        if ($is_update) {
            $rules["id"] = ["required", "exists:users,id"];
        } else {
            $rules["email"][] = "unique:users,email";
            $rules["password"] = ["required", Password::min(8)->letters()->numbers()];
        }
        return $rules;
    }
}
