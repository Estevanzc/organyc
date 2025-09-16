<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
