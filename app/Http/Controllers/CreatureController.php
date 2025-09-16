<?php

namespace App\Http\Controllers;

use App\Models\Clas;
use App\Models\Domain;
use App\Models\Family;
use App\Models\Genu;
use App\Models\Kingdom;
use App\Models\Order;
use App\Models\Phylum;
use App\Models\Plant;
use App\Models\Animal;
use App\Models\Specie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CreatureController extends Controller {
    public function recognizer(Request $request) {
        $request_data = $request->validate([
            "image" => ['file', 'image', 'mimes:jpeg,png,jpg,svg', "max:5120"],
            "is_plant" => ["nullable"],
        ]);
        $image = $request->file('image');
        $is_plant = ($request_data["is_plant"] ?? "off") == "on";
        $api_key = env($is_plant ? "PLANTNET_API_KEY" : "INATURALIST_API_KEY");
        $url = $is_plant ? "https://my-api.plantnet.org/v2/identify/all?api-key={$api_key}" : "https://api.inaturalist.org/v1/computervision/score_image";
        if ($is_plant) {
            $response = Http::withOptions([
                'verify' => false,
            ])->attach(
                    'images',
                    file_get_contents($image->getRealPath()),
                    $image->getClientOriginalName()
                )->post($url, [
                        'organs' => 'auto',
                    ]);
            //dd("plant", $response);
        } else {
            $response = Http::withOptions([
                'verify' => false,
            ])->withToken($api_key)
                ->attach(
                    'image',
                    file_get_contents($image->getRealPath()),
                    $image->getClientOriginalName()
                )->post($url, [
                        'taxon_id' => 1,
                    ]);
            //dd("animal", $response);
        }
        if ($response->successful()) {
            $response = $response["results"][0];
            $score = (float) $response[($is_plant ? "score" : "combined_score")];
            $score = (float) number_format(($score <= 1 ? $score*100 : $score), 1);
            $gbif_id = 0;
            if ($is_plant) {
                $gbif_id = (int) $response["gbif"]["id"];
            } else {
                $gbif_response = $this->api_fetcher($response["taxon"]["name"]);
                $gbif_id = $gbif_response["usageKey"];
            }
            $creature = $this->api_fetcher($gbif_id, 1, 1);
            $creature_photo = $this->api_fetcher($creature["species"], 6);
            $creature_photo = $creature_photo["results"][0]["default_photo"]["medium_url"];
            $eol_id = null;
            $eol_names = $this->api_fetcher($creature["species"], 7)["results"];
            foreach ($eol_names as $name) {
                if ($name["title"] == $creature["species"]) {
                    $eol_id = (int) $name["id"];
                    break;
                }
            }
            $eol_names = $this->api_fetcher($eol_id, 8, 1)["taxonConcept"]["vernacularNames"];
            $eol_name = "";
            foreach ($eol_names as $name) {
                if ($name["language"] == "en") {
                    $eol_name = $name["vernacularName"];
                    break;
                }
            }
            return response()->json([
                "gbif_id" => $gbif_id,
                "is_plant" => $is_plant,
                "specie" => $creature["species"],
                "common_name" => $eol_name,
                "score" => $score,
                "genus" => $creature["genus"],
                "photo" => $creature_photo,
            ]);
        }
        return response()->json([
            'status' => $response->status(),
            'error' => $response->body(),
        ], $response->status());
    }
    public function view($gbif_id, $is_plant = 0) {
        $creature = ([Animal::class, Plant::class][$is_plant])::where("gbif_id", $gbif_id)->first();
        $is_plant = $is_plant == 1 ? true : false;
        if (empty($creature)) {
            return redirect()->route("creature.create", [
                "gbif_id" => $gbif_id,
                "is_plant" => $is_plant ? 1 : 0,
            ]);
        }
        return response()->json([
            "status" => 200,
            "creature" => $creature,
        ]);
    }
    public function create($gbif_id, $is_plant = 0) {
        $is_plant = $is_plant == 1 ? true : false;
        $form_data = [
            ["common_name" => "","conservation_status" => "","type" => "","growth_form" => "","leaf_type" => "","leaf_arrangement" => "","fruit_type" => "","root_type" => "","soil" => "","sunlight" => "","water" => "","reproduction" => "","height" => "","locale" => "","habitat" => "","diet" => "","life_span" => "","growth_time" => "","color" => "","toxicity_level" => "","treatment_necessity" => "","description" => "","inaturalist_id" => "","gbif_id" => $gbif_id,"eol_id" => ""],
            ["common_name" => "","conservation_status" => "","weight" => "","height" => "","length" => "","locale" => "","habitat" => "","diet" => "","reproduction" => "","life_span" => "","color" => "","danger_level" => "","treatment_necessity" => "","prevention" => "","description" => "","inaturalist_id" => "","gbif_id" => $gbif_id,"eol_id" => ""]
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
        $eol_data = $this->common_names($gbif_data["species"]);
        $form_data["eol_id"] = $eol_data[0];
        $form_data["common_name"] = $eol_data[1];
        $inaturalist_data = $this->api_fetcher($gbif_data["species"], 6)["results"];
        foreach ($inaturalist_data as $data) {
            if ($data["name"] == $gbif_data["species"]) {
                $inaturalist_data = $data;
                break;
            }
        }
        $form_data["inaturalist_id"] = (int) $inaturalist_data["id"];
        $form_data["photo"] = $inaturalist_data["default_photo"]["medium_url"];
        $common_name = explode(" ", $eol_data[1]);
        $common_name = $common_name[(sizeof($common_name)-1)];
        $conservation_data = $this->api_fetcher($gbif_id, 3);
        $form_data["conservation_status"] = $conservation_data["category"] ?? "";
        if (!$is_plant) {
            $animals_data = $this->api_fetcher($common_name, 9);
            $animal_data = null;
            $matches = [];
            $idx = 0;
            foreach ($animals_data as $animal) {
                if ($animal["name"] == $eol_data[1] || ($animal["taxonomy"]["scientific_name"] ?? "") == $gbif_data["species"]) {
                    $animal_data = $animal;
                    break;
                } else {
                    $animal_name = explode(" ", $animal["name"]);
                    $score = 0;
                    foreach ($eol_data[2] as $names) {
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
            $form_data["diet"] = $animal_data["characteristics"]["diet"];
            $form_data["life_span"] = trim($animal_data["characteristics"]["lifespan"]);
            $form_data["weight"] = trim(explode("(", $animal_data["characteristics"]["weight"])[0]);
            $form_data["color"] = $animal_data["characteristics"]["color"];
            $form_data["locale"] = $animal_data["locations"][0];
            $form_data["habitat"] = $animal_data["characteristics"]["habitat"];
            foreach ($form_data["taxon"] as $taxon_name => $taxon_value) {
                if (empty($taxon_value)) {
                    $form_data["taxon"][$taxon_name] = $animal_data["taxonomy"][(["kingdom" => "kingdom","phylum" => "phylum","class" => "class","order" => "order","family" => "family","genu" => "genus","specie" => "scientific_name",][$taxon_name])] ?? "";
                }
            }
        }
        return response()->json([
            "status" => 200,
            "form_data" => $form_data,
        ]);
    }
    public function common_names($species) {
        $eol_data = $this->api_fetcher($species, 7)["results"];
        $eol_id = null;
        foreach ($eol_data as $name) {
            if ($name["title"] == $species) {
                $eol_id = $name["id"];
                break;
            }
        }
        $eol_data = $this->api_fetcher($eol_id, 8)["taxonConcept"]["vernacularNames"];
        foreach ($eol_data as $name) {
            if ($name["language"] == "en") {
                return [
                    $eol_id,
                    $name["vernacularName"],
                    array_map(function($name) {return explode(" ", strtolower($name["vernacularName"]));}, array_filter($eol_data, function($name) {return $name["language"] == "en";})),
                ];
            }
        }
    }
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
        ][$search_type];
        $response = Http::withOptions([
            'verify' => false, // ⚠️ only for local development
        ])->get($query_url);
        if (!$response->successful()) {
            return response()->json([
                'status' => $response->status(),
                'error'  => $response->body(),
            ], $response->status());
        }
        return $response->json();
    }
}
