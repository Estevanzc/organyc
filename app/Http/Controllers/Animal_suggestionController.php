<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Animal_suggestionController extends Controller {
    public function index() {
    }
    public function create($gbif_id, $is_plant) {
        $is_plant = $is_plant == 1 ? true : false;
        $form_data = $this->creature_header($gbif_id, $is_plant);
        if (!$is_plant) {
            $animals_data = $this->api_fetcher($form_data[2], 9);
            $animal_data = null;
            $matches = [];
            $idx = 0;
            foreach ($animals_data as $animal) {
                if ($animal["name"] == $form_data[1][0] || ($animal["taxonomy"]["scientific_name"] ?? "") == $form_data[3]["species"]) {
                    $animal_data = $animal;
                    break;
                } else {
                    $animal_name = explode(" ", $animal["name"]);
                    $score = 0;
                    foreach ($form_data[1][1] as $names) {
                        foreach ($animal_name as $name) {
                            $score += in_array(strtolower($name), $names) ? 1 : -1;
                        }
                    }
                    $matches[] = [
                        $idx,
                        $score,
                    ];
                }
                $idx ++;
            }
            if (empty($animal_data)) {
                $match_item = [
                    0,
                    0,
                ];
                foreach ($matches as $item) {
                    if ($item[1] > $match_item[1]) {
                        $match_item = $item;
                    }
                }
                $animal_data = $animals_data[$match_item[0]];
            }
            $form_data[0]["diet"] = $animal_data["characteristics"]["diet"];
            $form_data[0]["life_span"] = trim($animal_data["characteristics"]["lifespan"]);
            $form_data[0]["weight"] = trim(explode("(", $animal_data["characteristics"]["weight"])[0]);
            $form_data[0]["color"] = $animal_data["characteristics"]["color"];
            $form_data[0]["locale"] = $animal_data["locations"][0];
            $form_data[0]["habitat"] = $animal_data["characteristics"]["habitat"];
            foreach ($form_data[0]["taxon"] as $taxon_name => $taxon_value) {
                if (empty($taxon_value)) {
                    $form_data[0]["taxon"][$taxon_name] = $animal_data["taxonomy"][(["kingdom" => "kingdom","phylum" => "phylum","class" => "class","order" => "order","family" => "family","genu" => "genus","specie" => "scientific_name",][$taxon_name])] ?? "";
                }
            }
        }
        return [
            "form_data" => $form_data[0],
        ];
    }
    public function store(Request $request) {
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
