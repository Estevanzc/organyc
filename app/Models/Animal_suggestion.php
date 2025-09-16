<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Animal_suggestion extends Model {
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
        "photo",
        "kingdom",
        "phylum",
        "class",
        "order",
        "family",
        "genu",
        "specie",
    ];
    public function specie(): BelongsTo {
        return $this->belongsTo(Specie::class);
    }
}
