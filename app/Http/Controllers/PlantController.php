<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Plant_suggestionRequest;
use App\Http\Requests\PlantRequest;
use App\Models\Plant;
use App\Models\Plant_photo;
use App\Models\Plant_suggestion;
use Illuminate\Http\Request;

class PlantController extends Controller {
    public function index() {
    }
    public function create() {
    }
    public function store(Plant_suggestionRequest $request) {
        $request_data = $request->validated();
        $suggestion = Plant_suggestion::find($request_data["id"]);
        if (empty($suggestion)) {
            return; //redirect to home with errors
        }
        $specie_id = $this->taxon_creater([
            "kingdom" => $request_data['kingdom'],
            "phylum" => $request_data['phylum'],
            "class" => $request_data['class'],
            "order" => $request_data['order'],
            "family" => $request_data['family'],
            "genu" => $request_data['genu'],
            "specie" => $request_data['specie'],
        ]);
        $photo_name = $this->image_download($suggestion->photo);
        $plant = Plant::create([
            "common_name" => $request_data["common_name"],
            "conservation_status" => $request_data["conservation_status"],
            "type" => $request_data["type"],
            "growth_form" => $request_data["growth_form"],
            "leaf_type" => $request_data["leaf_type"],
            "leaf_arrangement" => $request_data["leaf_arrangement"],
            "fruit_type" => $request_data["fruit_type"],
            "root_type" => $request_data["root_type"],
            "soil" => $request_data["soil"],
            "sunlight" => $request_data["sunlight"],
            "water" => $request_data["water"],
            "reproduction" => $request_data["reproduction"],
            "height" => $request_data["height"],
            "locale" => $request_data["locale"],
            "habitat" => $request_data["habitat"],
            "diet" => $request_data["diet"],
            "life_span" => $request_data["life_span"],
            "growth_time" => $request_data["growth_time"],
            "color" => $request_data["color"],
            "toxicity_level" => $request_data["toxicity_level"],
            "treatment_necessity" => $request_data["treatment_necessity"],
            "description" => $request_data["description"],
            "inaturalist_id" => $request_data["inaturalist_id"],
            "gbif_id" => $request_data["gbif_id"],
            'specie_id' => $specie_id,
        ]);
        Plant_photo::create([
            "photo" => $photo_name,
            "plant_id" => $plant->id,
        ]);
        $suggestion->delete();
        return [
            "plant" => $plant,// return the page of the animal
        ];
    }
    public function show(string $id) {
    }
    public function edit(string $id) {
    }
    public function update(PlantRequest $request) {
        $request_data = $request->validated();
    }
    public function destroy(string $id) {
    }
}
