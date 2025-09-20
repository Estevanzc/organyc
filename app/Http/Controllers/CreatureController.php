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
use App\Models\Plant_suggestion;
use App\Models\Animal_suggestion;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

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
        $creature = ([Plant_suggestion::class, Animal_suggestion::class][$is_plant ? 0 : 1])::where("gbif_id", $gbif_id)->first();
        return redirect()->route((($is_plant ? "plant" : "animal").".suggestion.".(empty($creature) ? "create" : "edit")), [$gbif_id, ($is_plant ? 1 : 0)]);
    }
}
