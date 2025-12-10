<?php

namespace App\Http\Controllers;

use App\Models\Animal_activity;
use App\Models\Daily_creature;
use App\Models\Plant;
use App\Models\Animal;
use App\Models\Plant_activity;
use Illuminate\Http\Request;
use App\Models\Plant_suggestion;
use App\Models\Animal_suggestion;
use App\Http\Controllers\Controller;
// Removed: use Illuminate\Support\Facades\Auth; // No longer needed
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;
use Inertia\Inertia;// For safer array access

class CreatureController extends Controller
{
    public function index()
    {
        $daily_creature_log = Daily_creature::latest()->first();

        if (!$daily_creature_log) {
            return Inertia::render("Home", [
                "daily_creature" => null,
                "photo" => null,
            ]);
        }

        $model_class = $daily_creature_log->is_plant ? Plant::class : Animal::class;
        $daily_creature = $model_class::find($daily_creature_log->creature_id);

        if (!$daily_creature) {
            return Inertia::render("Home", [
                "daily_creature" => null,
                "photo" => null,
            ]);
        }

        $photo = Arr::get($daily_creature->photos, '0.url', null);
        $photo = $daily_creature->photos[0] ?? null;


        return Inertia::render("Home", [
            "daily_creature" => $daily_creature,
            "photo" => $photo,
        ]);
    }

    public function response_builder(array $response, bool $is_plant): array
    {
        $top_results = array_slice($response, 0, 3);
        $builded_reponse = [];

        foreach ($top_results as $current_response) {
            try {
                $score_key = $is_plant ? "score" : "combined_score";
                $score = (float) Arr::get($current_response, $score_key, 0);
                $score = (float) number_format(($score <= 1.0 ? $score * 100 : $score), 1);

                $gbif_id = 0;
                $creature_specie = null;
                $common_name = null;
                $creature_photo = null;

                if ($is_plant) {
                    $gbif_id = (int) Arr::get($current_response, "gbif.id", 0);
                } else {
                    $taxon_name = Arr::get($current_response, "taxon.name");
                    if ($taxon_name) {
                        // Assuming api_fetcher is defined elsewhere and works
                        $gbif_response = $this->api_fetcher($taxon_name);
                        $gbif_id = Arr::get($gbif_response, "usageKey", 0);
                    }
                }

                if ($gbif_id > 0) {
                    // Assuming api_fetcher and common_names are defined elsewhere and work
                    $creature = $this->api_fetcher($gbif_id, 1, 1);
                    $creature_specie = Arr::get($creature, "species");
                    $creature_genus = Arr::get($creature, "genus");

                    if ($creature_specie) {
                        $creature_photo_response = $this->api_fetcher($creature_specie, 6);
                        $creature_photo = Arr::get($creature_photo_response, "results.0.default_photo.medium_url");
                    }

                    $common_names_response = $this->common_names($gbif_id);
                    $common_name = Arr::get($common_names_response, 0, 'N/A');

                    $builded_reponse[] = [
                        "gbif_id" => $gbif_id,
                        "is_plant" => $is_plant,
                        "specie" => $creature_specie,
                        "common_name" => $common_name,
                        "score" => $score,
                        "genus" => $creature_genus,
                        "photo" => $creature_photo,
                    ];
                }
            } catch (\Exception $e) {
                Log::error("Error processing recognition result: " . $e->getMessage());
                continue;
            }
        }
        return $builded_reponse;
    }

    /**
     * Handles the image recognition request. This method does not require user authentication.
     * The 401 error observed is highly likely due to a missing or invalid external API Key.
     */
    public function recognizer(Request $request)
    {
        $request_data = $request->validate([
            "image" => ['required', 'file', 'image', 'mimes:jpeg,png,jpg,svg', "max:5120"],
            "is_plant" => ["nullable"],
        ]);

        $image = $request->file('image');
        // Checkbox value needs to be explicitly checked for 'on'
        $is_plant = ($request_data["is_plant"] ?? "off") == "on";

        $api_key_env_var = $is_plant ? "PLANTNET_API_KEY" : "INATURALIST_API_KEY";
        $api_key = env($api_key_env_var);

        if (!$api_key) {
            Log::error("Missing API Key for " . $api_key_env_var);
            // Return 500 or 503 error since this is a server configuration issue
            return response()->json(['error' => "Missing server configuration. Please ensure the '{$api_key_env_var}' environment variable is set."], 500);
        }

        $url = $is_plant
            ? "https://my-api.plantnet.org/v2/identify/all?api-key={$api_key}"
            : "https://api.inaturalist.org/v1/computervision/score_image";

        $http_request = Http::withOptions([
            'verify' => false, // Use with caution in production
        ]);

        if ($is_plant) {
            $response = $http_request->attach(
                'images',
                file_get_contents($image->getRealPath()),
                $image->getClientOriginalName()
            )->post($url, [
                        'organs' => 'auto',
                    ]);
        } else {
            // iNaturalist API
            $response = $http_request
                ->attach(
                    'image',
                    file_get_contents($image->getRealPath()),
                    $image->getClientOriginalName()
                )->post($url, [
                        'taxon_id' => 1,
                    ]);
        }

        if ($response->successful()) {
            $results = $response->json('results', []);
            $processed_response = $this->response_builder($results, $is_plant);
            return response()->json($processed_response);
        }

        // Handle external API authentication errors (401/403) specifically
        if ($response->status() === 401 || $response->status() === 403) {
            Log::error("External API authentication failed (Missing or invalid PlantNet/iNaturalist API Key): " . $response->status() . " - " . $response->body());
            // This 401/403 is from the external service, not Laravel. We return a 503 (Service Unavailable) 
            // to the client to indicate an issue with the third-party dependency.
            return response()->json([
                'status' => 503,
                'error' => 'External Recognition Service Error. Check the API Key in your environment file.',
                'details' => $response->json(),
            ], 503);
        }

        // Handle other API failures
        Log::error("API recognition failed: " . $response->status() . " - " . $response->body());
        return response()->json([
            'status' => $response->status(),
            'error' => 'Recognition API failed to return a successful response.',
            'details' => $response->json(),
        ], $response->status());
    }

    public function view($gbif_id, $is_plant_int = 0)
    {
        $is_plant_bool = $is_plant_int == 1;

        $model_class = $is_plant_bool ? Plant::class : Animal::class;

        $creature = $model_class::where("gbif_id", $gbif_id)->first();

        if (empty($creature)) {
            return redirect()->route("creature.create", [
                "gbif_id" => $gbif_id,
                "is_plant" => $is_plant_int,
            ]);
        }

        // Removed the Auth::check() block that created an Animal/Plant_activity log.
        // The view method is now fully public and performs no authentication checks.

        return [
            "creature" => $creature,
        ];
    }

    public function create($gbif_id, $is_plant_int = 0)
    {
        $is_plant_bool = $is_plant_int == 1;

        $suggestion_model = $is_plant_bool ? Plant_suggestion::class : Animal_suggestion::class;
        $creature = $suggestion_model::where("gbif_id", $gbif_id)->first();

        $route_name_base = $is_plant_bool ? "plant" : "animal";
        $action = empty($creature) ? "create" : "edit";

        return redirect()->route("{$route_name_base}.suggestion.{$action}", [$gbif_id, $is_plant_int]);
    }
}