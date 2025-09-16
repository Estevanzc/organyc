<?php

use App\Http\Controllers\Animal_suggestionController;
use App\Http\Controllers\CreatureController;
use App\Http\Controllers\Plant_suggestionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('test_api');
});

Route::prefix("/creatures")->group(function() {
    Route::get("/view/{gbif_id}/{is_plant?}", [CreatureController::class, "view"])->name("creature.view");
    Route::get("/create/{gbif_id}/{is_plant?}", [CreatureController::class, "create"])->name("creature.create");
    Route::prefix("/plants")->group(function() {
        Route::prefix("/suggestion")->group(function() {
            Route::get("/create/{gbif_id}/{is_plant?}", [Plant_suggestionController::class, "create"])->name("plant.suggestion.create");
        });
    });
    Route::prefix("/animals")->group(function() {
        Route::prefix("/suggestion")->group(function() {
            Route::get("/create/{gbif_id}/{is_plant?}", [Animal_suggestionController::class, "create"])->name("animal.suggestion.create");
        });
    });
});
Route::post("/test", [CreatureController::class, "recognizer"])->name("api_test");
Route::get("/api/{search_value}/{search_type?}/{is_id?}", [CreatureController::class, "api_fetcher"])->name("gbif_api");
