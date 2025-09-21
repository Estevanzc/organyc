<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Plant_suggestionRequest;
use App\Models\Plant_suggestion;
use Illuminate\Http\Request;

class Plant_suggestionController extends Controller {
    public function index() {
    }
    public function create($gbif_id, $is_plant) {
        $is_plant = $is_plant == 1 ? true : false;
        $form_data = $this->creature_header($gbif_id, $is_plant);
        return [
            "form_data" => $form_data,
        ];
    }
    public function store(Plant_suggestionRequest $request) {
        $request_data = $request->validated();
        Plant_suggestion::create($request_data);
        return redirect()->route("");
    }
    public function edit($gbif_id) {
        $suggestion = Plant_suggestion::where("gbif_id", $gbif_id)->first();
        return [
            "suggestion" => $suggestion,
        ];
    }
    public function update(Plant_suggestionRequest $request) {
        $request_data = $request->validated();
        $suggestion = Plant_suggestion::find($request_data["id"]);
        $suggestion->update($request_data);
        return []; ///página de listagem de sugestões
    }
    public function destroy(Plant_suggestion $plant_suggestion) {
        $plant_suggestion->delete();
        return redirect()->route("");
    }
}
