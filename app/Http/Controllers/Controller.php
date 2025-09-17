<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

abstract class Controller {
    public function api_fetcher($search_value, $search_type = 0, $is_id = false) {
        $query_url = [
            "https://api.gbif.org/v1/species/match?name=$search_value",
            "https://api.gbif.org/v1/species/$search_value",
            "https://api.gbif.org/v1/species/$search_value/vernacularNames",
            "https://api.gbif.org/v1/species/$search_value/iucnRedListCategory",
            "https://api.gbif.org/v1/species/$search_value/distributions",
            "https://api.gbif.org/v1/species/$search_value/descriptions",
            "https://api.inaturalist.org/v1/taxa?q=$search_value",
            "https://eol.org/api/search/1.0.json?q=$search_value&page=1&exact=true",
            "https://eol.org/api/pages/1.0/$search_value.json?details=true&taxonomy=true&common_names=true&traits=true",
            "https://api.api-ninjas.com/v1/animals?name=$search_value&X-Api-Key=".env("API_NINJA_KEY"),
            "https://www.inaturalist.org/users/api_token",
        ][$search_type];
        $response = Http::withOptions([
            'verify' => false,
        ])->get($query_url);
        if (!$response->successful()) {
            return response()->json([
                'status' => $response->status(),
                'error'  => $response->body(),
            ], $response->status());
        }
        return $response->json();
    }
    public function common_names($gbif_id) {
        $common_names = array_filter($this->api_fetcher($gbif_id, 2, 1)["results"], function($name) {
            return $name["language"] == "eng";
        });
        $names_score = [];
        foreach ($common_names as $name) {
            $current_name = $name["vernacularName"];
            if ($names_score[$current_name] ?? false) {
                $names_score[$current_name][1] += 1;
            } else {
                $names_score[$current_name] = [
                    $current_name,
                    1
                ];
            }
        }
        $common_name = ["", 0];
        foreach ($names_score as $name => $value) {
            if ($common_name[1] < $value[1]) {
                $common_name = [$name, $value[1]];
            }
        }
        return [$common_name[0], array_values(array_map(function($name) {return explode(" ", strtolower($name[0]));}, $names_score))];
    }
    public function creature_header($gbif_id, $is_plant) {
        $form_data = [
            ["common_name" => "","conservation_status" => "","type" => "","growth_form" => "","leaf_type" => "","leaf_arrangement" => "","fruit_type" => "","root_type" => "","soil" => "","sunlight" => "","water" => "","reproduction" => "","height" => "","locale" => "","habitat" => "","diet" => "","life_span" => "","growth_time" => "","color" => "","toxicity_level" => "","treatment_necessity" => "","description" => "","inaturalist_id" => "","gbif_id" => $gbif_id],
            ["common_name" => "","conservation_status" => "","weight" => "","height" => "","length" => "","locale" => "","habitat" => "","diet" => "","reproduction" => "","life_span" => "","color" => "","danger_level" => "","treatment_necessity" => "","prevention" => "","description" => "","inaturalist_id" => "","gbif_id" => $gbif_id]
        ][$is_plant ? 0 : 1];
        $gbif_data = $this->api_fetcher($gbif_id, 1, 1);
        $form_data["taxon"] = [
            "kingdom" => $gbif_data["kingdom"] ?? "",
            "phylum" => $gbif_data["phylum"] ?? "",
            "class" => $gbif_data["class"] ?? "",
            "order" => $gbif_data["order"] ?? "",
            "family" => $gbif_data["family"] ?? "",
            "genu" => $gbif_data["genus"] ?? "",
            "specie" => $gbif_data["species"] ?? "",
        ];
        $common_names = $this->common_names($gbif_id);
        $form_data["common_name"] = $common_names[0];
        $inaturalist_data = $this->api_fetcher($gbif_data["species"], 6)["results"];
        foreach ($inaturalist_data as $data) {
            if ($data["name"] == $gbif_data["species"]) {
                $inaturalist_data = $data;
                break;
            }
        }
        $form_data["inaturalist_id"] = (int) $inaturalist_data["id"];
        $form_data["photo"] = $inaturalist_data["default_photo"]["medium_url"];
        $common_name = explode(" ", $common_names[0]);
        $common_name = $common_name[(sizeof($common_name)-1)];
        $conservation_data = $this->api_fetcher($gbif_id, 3);
        $convervation_codes = [
            "EX" => "Extinct",
            "EW" => "Extinct in the Wild",
            "CR" => "Critically Endangered",
            "EN" => "Endangered",
            "VU" => "Vulnerable",
            "NT" => "Near Threatened",
            "LC" => "Least Concern",
            "DD" => "Data Deficient",
            "NE" => "Not Evaluated",
        ];
        if ($conservation_data["category"] ?? false) {
            $form_data["conservation_status"] = $convervation_codes[$conservation_data["code"]];
        }
        return $is_plant ? $form_data : [$form_data, $common_names, $common_name, $gbif_data];
    }
}
