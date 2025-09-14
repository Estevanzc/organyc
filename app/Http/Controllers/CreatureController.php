<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

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
            $creature_names = $this->api_fetcher($gbif_id, 2, 1)["results"];
            foreach ($creature_names as $name) {
                if ($name["language"] == "eng" && $name["source"] == "Catalogue of Life") {
                    $creature_names = $name["vernacularName"];
                    break;
                }
            }
            return response()->json([
                "gbif_id" => $gbif_id,
                "specie" => $creature["species"],
                "common_name" => $creature_names,
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
    public function api_test(Request $request) {
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
            $creature_names = $this->api_fetcher($gbif_id, 2, 1)["results"];
            foreach ($creature_names as $name) {
                if ($name["language"] == "eng" && $name["source"] == "Catalogue of Life") {
                    $creature_names = $name["vernacularName"];
                    break;
                }
            }
            return response()->json([
                "gbif_id" => $gbif_id,
                "specie" => $creature["species"],
                "common_name" => $creature_names,
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
    public function api_fetcher($search_value, $search_type = 0, $is_id = false) {
        $query_url = ["https://api.gbif.org/v1/species/match?name=$search_value", "https://api.gbif.org/v1/species/$search_value","https://api.gbif.org/v1/species/$search_value/vernacularNames", "https://api.gbif.org/v1/species/$search_value/iucnRedListCategory", "https://api.gbif.org/v1/species/$search_value/distributions", "https://api.gbif.org/v1/species/$search_value/descriptions", "https://api.inaturalist.org/v1/taxa?q=$search_value"][$search_type];
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
