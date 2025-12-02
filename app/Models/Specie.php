<?php

namespace App\Models;

use App\Models\Plant;
use App\Models\Animal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Specie extends Model {
    use HasFactory;
    protected $fillable = [
        "name",
        "genu_id",
    ];
    public function genu(): BelongsTo {
        return $this->belongsTo(Genu::class);
    }
    public function animals(): HasMany {
        return $this->hasMany(Animal::class);
    }
    public function plants(): HasMany {
        return $this->hasMany(Plant::class);
    }
    public function creature($is_plant, $specie) {
        $specie_id = Specie::where("name", $specie)->first();
        $specie_id = empty($specie_id) ? null : $specie_id->id;
        $creature = null;
        if ($specie_id) {
            $creature = ([Plant::class, Animal::class][$is_plant ? 0 : 1])::where("specie_id", $specie_id)->first();
        }
        return $creature;
    }
}
