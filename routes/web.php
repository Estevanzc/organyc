<?php

use App\Http\Controllers\Animal_suggestionController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\CreatureController;
use App\Http\Controllers\Plant_suggestionController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\LoginVerify;
use Illuminate\Support\Facades\Route;

Route::get("/", [CreatureController::class, "index"])->name("index");
Route::prefix("/creatures")->group(function () {
    Route::get("/view/{gbif_id}/{is_plant?}", [CreatureController::class, "view"])->name("creature.view");
    Route::get("/create/{gbif_id}/{is_plant?}", [CreatureController::class, "create"])->name("creature.create")->middleware(LoginVerify::class);
    Route::prefix("/plants")->group(function () {
        Route::get("/view/{plant}", [PlantController::class, "view"])->name("plant.view");
        Route::get("/catalogue", [PlantController::class, "index"])->name("plant.index");
        Route::get("/filter/{filter?}", [PlantController::class, "filter"])->name("plant.filter"); //the filter value can be null, in this case, it just returns every item in the database. Always paginated
        Route::put("/store", [PlantController::class, "store"])->name("plant.store")->middleware(LoginVerify::class);
        Route::prefix("/suggestion")->group(function () {
            Route::get("/create/{gbif_id}/{is_plant?}", [Plant_suggestionController::class, "create"])->name("plant.suggestion.create");
            Route::get("/edit/{gbif_id}", [Plant_suggestionController::class, "edit"])->name("plant.suggestion.edit");
        })->middleware(LoginVerify::class);
    });
    Route::prefix("/animals")->group(function () {
        Route::get("/view/{animal}", [AnimalController::class, "view"])->name("animal.view");
        Route::get("/filter/{filter?}", [AnimalController::class, "filter"])->name("animal.filter"); //the filter value can be null, in this case, it just returns every item in the database. Always paginated
        Route::put("/store", [AnimalController::class, "store"])->name("animal.store")->middleware(LoginVerify::class);
        Route::prefix("/suggestion")->group(function () {
            Route::get("/create/{gbif_id}/{is_plant?}", [Animal_suggestionController::class, "create"])->name("animal.suggestion.create");
            Route::get("/edit/{gbif_id}", [Animal_suggestionController::class, "edit"])->name("animal.suggestion.edit");
        })->middleware(LoginVerify::class);
    });
});
Route::prefix("/report")->group(function() {
    Route::get("/", [ReportController::class, "index"])->name("report.index");
    Route::get("/create", [ReportController::class, "create"])->name("report.create");
    Route::post("/store", [ReportController::class, "store"])->name("report.store");
})->middleware(LoginVerify::class);

Route::get("/login", [UserController::class, "login"])->name("login");
Route::get("/register", [UserController::class, "logon"])->name("logon");
Route::prefix("/user")->group(function () {
    Route::get("/profile/{user}", [UserController::class, "index"])->name("user.profile")->middleware(LoginVerify::class);
    Route::prefix("/password")->group(function() {
        Route::get("/recover/{email}", [UserController::class, "password_recover"])->name("user.password.recover");
        Route::get("/reseter/{token}", [UserController::class, "password_reseter"])->name("user.password.reseter");
        Route::post("/update", [UserController::class, "password_update"])->name("user.password.update");
    })->middleware(LoginVerify::class);
    Route::post("/login", [UserController::class, "auth_login"])->name("auth.login");
    Route::post("/logon", [UserController::class, "auth_logon"])->name("auth.logon");
    Route::get("/delete/{user}", [UserController::class, "destroy"])->name("user.delete")->middleware(LoginVerify::class);
});

Route::prefix("/test")->group(function () {
    Route::post("/", [CreatureController::class, "recognizer"])->name("api_test");
    Route::get("/taxon/{taxon?}", [TestController::class, "taxon_creater"])->name("taxon_test");
});

Route::get("/api/{search_value}/{search_type?}/{is_id?}", [CreatureController::class, "api_fetcher"])->name("gbif_api");
