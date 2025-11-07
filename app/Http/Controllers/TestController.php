<?php

namespace App\Http\Controllers;

use App\Models\Clas;
use App\Models\Genu;
use App\Models\Order;
use App\Models\Family;
use App\Models\Phylum;
use App\Models\Specie;
use App\Models\Kingdom;
use Illuminate\Http\Request;

class TestController extends Controller {
    public function taxon_make($taxon) {
        $taxon_table = [
            "kingdom" => Kingdom::class,
            "phylum" => Phylum::class,
            "class" => Clas::class,
            "order" => Order::class,
            "family" => Family::class,
            "genu" => Genu::class,
            "specie" => Specie::class,
        ];
        $past_level = [];
        foreach ($taxon as $level => $value) {
            $model = $taxon_table[$level];
            $taxon_level = $model::where("name", $value)->first();
            if (empty($taxon_level)) {
                $fields = [
                    "name" => $value,
                ];
                if (!empty($past_level)) {
                    $fields[($past_level[1]."_id")] = $past_level[0]["id"];
                }
                $past_level = [$model::create($fields)->toArray(), $level];
            } else {
                $past_level = [$taxon_level->toArray(), $level];
            }
        }
        return $past_level[0]["id"];
    }
    public function taxon_creater($taxon = null) {
        $taxons = [
        ];
        foreach ($taxons as $taxon) {
            $this->taxon_make($taxon);
        }
    }
}
