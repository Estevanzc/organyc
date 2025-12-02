<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\Animal_report;
use App\Models\Plant;
use App\Models\Plant_report;
use Illuminate\Http\Request;

class ReportController extends Controller {
    public function index() {
        $animals = Animal_report::all();
        $plants = Plant_report::all();

        $reports = $animals
            ->merge($plants)
            ->sortByDesc('created_at')
            ->values();
        return [
            "reports" => $reports,
        ];
    }
    public function create($is_plant, $creature_id) {
        $creature = ([[Plant::class, "plant"], [Animal::class, "animal"]][$is_plant])::find($creature_id);
        return [
            "creature" => $creature,
        ];
    }
    public function store(Request $request) {
        $creature_type = ["plant","animal"][$request["is_plant"] ?? 0];
        $request_data = $request->validate([
            "description" => ["required"],
            "creature_id" => ["required", "exists:".$creature_type."s,id"],
            "is_plant" => ["required"],
        ]);
        $creature = ([Plant::class, Animal::class][$request_data["is_plant"]])::find($request_data["creature_id"]);
        $report = [Plant_report::class, Animal_report::class][$request_data["is_plant"]];
        $report::create([
            "description" => $request_data["description"],
            ($creature_type."_id") => $creature->id,
        ]);
    }
}
