<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Animal extends Model {
    use HasFactory;
    protected $fillable = [
        "common_name",
        "conservation_status",
        "weight",
        "height",
        "length",
        "locale",
        "habitat",
        "diet",
        "reproduction",
        "life_span",
        "color",
        "danger_level",
        "treatment_necessity",
        "prevention",
        "description",
        "inaturalist_id",
        "gbif_id",
        "eol_id",
        "specie_id",
    ];
    public function photos(): HasMany {
        return $this->hasMany(Animal_photo::class);
    }
    public function specie(): BelongsTo {
        return $this->belongsTo(Specie::class);
    }
}
