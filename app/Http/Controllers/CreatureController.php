<?php

namespace App\Http\Controllers;

use App\Models\Clas;
use App\Models\Genu;
use App\Models\Order;
use App\Models\Plant;
use App\Models\Animal;
use App\Models\Domain;
use App\Models\Family;
use App\Models\Phylum;
use App\Models\Specie;
use App\Models\Kingdom;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CreatureController extends Controller {
    public function response_builder($response, $is_plant) {
        $response_count = sizeof($response) < 3 ? sizeof($response)-1 : 2;
        $builded_reponse = [];
        for ($i=0; $i <= $response_count; $i++) {
            $current_response = $response[$i];
            $score = (float) $current_response[($is_plant ? "score" : "combined_score")];
            $score = (float) number_format(($score <= 1 ? $score*100 : $score), 1);
            $gbif_id = 0;
            if ($is_plant) {
                $gbif_id = (int) $current_response["gbif"]["id"];
            } else {
                $gbif_response = $this->api_fetcher($current_response["taxon"]["name"]);
                $gbif_id = $gbif_response["usageKey"];
            }
            $creature = $this->api_fetcher($gbif_id, 1, 1);
            $creature_photo = $this->api_fetcher($creature["species"], 6);
            $creature_photo = $creature_photo["results"][0]["default_photo"]["medium_url"];
            $common_name = $this->common_names($gbif_id)[0];
            $builded_reponse[] = [
                "gbif_id" => $gbif_id,
                "is_plant" => $is_plant,
                "specie" => $creature["species"],
                "common_name" => $common_name,
                "score" => $score,
                "genus" => $creature["genus"],
                "photo" => $creature_photo,
            ];
        }
        return $builded_reponse;
    }
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
            $response = $this->response_builder($response["results"], $is_plant);
            return response()->json($response);
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
        return [//verificar se é planta ou animal para retornar a página correta
            "creature" => $creature,
        ];
    }
    public function create($gbif_id, $is_plant = 0) {
        $is_plant = $is_plant == 1 ? true : false;
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
        $form_data["conservation_status"] = $conservation_data["category"] ?? "";
        if (!$is_plant) {
            $animals_data = $this->api_fetcher($common_name, 9);
            $animal_data = null;
            $matches = [];
            $idx = 0;
            foreach ($animals_data as $animal) {
                if ($animal["name"] == $common_names[0] || ($animal["taxonomy"]["scientific_name"] ?? "") == $gbif_data["species"]) {
                    $animal_data = $animal;
                    break;
                } else {
                    $animal_name = explode(" ", $animal["name"]);
                    $score = 0;
                    foreach ($common_names[1] as $names) {
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
        return [
            "form_data" => $form_data,
        ];
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
