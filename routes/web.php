<?php

use App\Http\Controllers\CreatureController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('test_api');
});

Route::prefix("/creature")->group(function() {
    Route::get("/view/{gbif_id}/{is_plant?}", [CreatureController::class, "view"])->name("creature.view");
    Route::get("/create/{gbif_id}/{is_plant?}", [CreatureController::class, "create"])->name("creature.create");
});
Route::post("/test", [CreatureController::class, "recognizer"])->name("api_test");
Route::get("/api/{search_value}/{search_type?}/{is_id?}", [CreatureController::class, "api_fetcher"])->name("gbif_api");
