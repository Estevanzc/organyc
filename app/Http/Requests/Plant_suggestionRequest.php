<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Plant_suggestionRequest extends FormRequest {
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
            "type" => ["nullable"],
            "growth_form" => ["nullable"],
            "leaf_type" => ["nullable"],
            "leaf_arrangement" => ["nullable"],
            "fruit_type" => ["nullable"],
            "root_type" => ["nullable"],
            "soil" => ["nullable"],
            "sunlight" => ["nullable"],
            "water" => ["nullable"],
            "reproduction" => ["nullable"],
            "height" => ["required"],
            "locale" => ["required"],
            "habitat" => ["required"],
            "diet" => ["nullable"],
            "life_span" => ["nullable"],
            "growth_time" => ["nullable"],
            "color" => ["nullable"],
            "toxicity_level" => ["nullable"],
            "treatment_necessity" => ["nullable"],
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
