<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class CreatureController extends Controller
{
    public function api_test(Request $request)
    {
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
        }
        if ($response->successful()) {
            return response()->json($response->json());
        }
        return response()->json([
            'status' => $response->status(),
            'error' => $response->body(),
        ], $response->status());
    }
}
