<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Animal_suggestionRequest;
use App\Models\Animal;
use App\Models\Animal_photo;
use App\Models\Animal_suggestion;
use Illuminate\Http\Request;

class AnimalController extends Controller {
    public function index() {
    }
    public function create() {
    }
    public function store(Animal_suggestionRequest $request) {
        $request_data = $request->validated();
        $suggestion = Animal_suggestion::find($request_data["id"]);
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
        dd();
        $animal = Animal::create([
            'common_name' => $request_data["common_name"],
            'conservation_status' => $request_data["conservation_status"],
            'weight' => $request_data["weight"],
            'height' => $request_data["height"],
            'length' => $request_data["length"],
            'locale' => $request_data["locale"],
            'habitat' => $request_data["habitat"],
            'diet' => $request_data["diet"],
            'reproduction' => $request_data["reproduction"],
            'life_span' => $request_data["life_span"],
            'color' => $request_data["color"],
            'danger_level' => $request_data["danger_level"],
            'treatment_necessity' => $request_data["treatment_necessity"],
            'prevention' => $request_data["prevention"],
            'description' => $request_data["description"],
            'inaturalist_id' => $request_data["inaturalist_id"],
            'gbif_id' => $request_data["gbif_id"],
            'specie_id' => $specie_id,
        ]);
        Animal_photo::create([
            "photo" => $photo_name,
            "animal_id" => $animal->id,
        ]);
        $suggestion->delete();
        dd($animal);
    }
    public function show(string $id) {
    }
    public function edit(string $id) {
    }
    public function update(Request $request, string $id) {
    }
    public function destroy(string $id) {
    }
}
