<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Animal_suggestionRequest extends FormRequest {
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
        $is_update = $this->isMethod("PUT");
        $rules = [
            "common_name" => ["required"],
            "conservation_status" => ["required"],
            "weight" => ["nullable"],
            "height" => ["nullable"],
            "length" => ["nullable"],
            "locale" => ["nullable"],
            "habitat" => ["required"],
            "diet" => ["nullable"],
            "reproduction" => ["nullable"],
            "life_span" => ["required"],
            "color" => ["required"],
            "danger_level" => ["nullable"],
            "treatment_necessity" => ["nullable"],
            "prevention" => ["nullable"],
            "description" => ["nullable"],
            "inaturalist_id" => ["required"],
            "gbif_id" => ["required"],
            "photo" => ["required"],
            "kingdom" => ["required"],
            "phylum" => ["required"],
            "class" => ["required"],
            "order" => ["required"],
            "family" => ["required"],
            "genu" => ["required"],
            "specie" => ["required"],
        ];
        if ($is_update) {
            $rules["id"] = ["required"];
        }
        return $rules;
    }
}
