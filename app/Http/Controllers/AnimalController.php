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
    public function store(Request $request) {
        //$request_data = $request->validated();
        $request_data = [
            "id" => 1,
            'common_name' => 'African Elephant',
            'conservation_status' => 'Endangered',
            'weight' => '6000 kg',
            'height' => '3.3 m',
            'length' => '6 m',
            'locale' => 'Sub-Saharan Africa',
            'habitat' => 'Savannas, forests, deserts, and marshes',
            'diet' => 'Herbivore',
            'reproduction' => 'Sexual',
            'life_span' => '60-70 years',
            'color' => 'Gray',
            'danger_level' => 'Dangerous',
            'treatment_necessity' => 'Urgent',
            'prevention' => 'Maintain safe distance, avoid provoking',
            'description' => 'The African elephant is the largest land animal on Earth.',
            'inaturalist_id' => 43662,
            'gbif_id' => 2440946,
            'photo' => 'https://inaturalist-open-data.s3.amazonaws.com/photos/20539855/medium.jpg',
            'kingdom' => 'Animalia',
            'phylum' => 'Chordata',
            'class' => 'Mammalia',
            'order' => 'Proboscidea',
            'family' => 'Elephantidae',
            'genus' => 'Loxodonta',
            'species' => 'Loxodonta africana',
        ];
        $suggestion = Animal_suggestion::find($request_data["id"]);
        $specie_id = $this->taxon_creater([
            "kingdom" => $request_data['kingdom'],
            "phylum" => $request_data['phylum'],
            "class" => $request_data['class'],
            "order" => $request_data['order'],
            "family" => $request_data['family'],
            "genu" => $request_data['genus'],
            "specie" => $request_data['species'],
        ]);
        $photo_name = $this->image_download($suggestion->photo);
        dd();
        $animal = Animal::create([
            'common_name' => 'African Elephant',
            'conservation_status' => 'Endangered',
            'weight' => '6000 kg',
            'height' => '3.3 m',
            'length' => '6 m',
            'locale' => 'Sub-Saharan Africa',
            'habitat' => 'Savannas, forests, deserts, and marshes',
            'diet' => 'Herbivore',
            'reproduction' => 'Sexual',
            'life_span' => '60-70 years',
            'color' => 'Gray',
            'danger_level' => 'Dangerous',
            'treatment_necessity' => 'Urgent',
            'prevention' => 'Maintain safe distance, avoid provoking',
            'description' => 'The African elephant is the largest land animal on Earth.',
            'inaturalist_id' => 43662,
            'gbif_id' => 2440946,
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
