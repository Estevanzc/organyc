<?php

use App\Http\Controllers\CreatureController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('test_api');
});

Route::post("/test", [CreatureController::class, "api_test"])->name("api_test");
Route::get("/api/{search_value}/{search_type?}/{is_id?}", [CreatureController::class, "api_fetcher"])->name("gbif_api");
