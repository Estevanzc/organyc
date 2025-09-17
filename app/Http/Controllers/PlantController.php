<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlantRequest;
use Illuminate\Http\Request;

class PlantController extends Controller {
    public function index() {
    }
    public function create() {
    }
    public function store(PlantRequest $request) {
        $request_data = $request->validated();
    }
    public function show(string $id) {
    }
    public function edit(string $id) {
    }
    public function update(PlantRequest $request) {
        $request_data = $request->validated();
    }
    public function destroy(string $id) {
    }
}
