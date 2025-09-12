<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Plant_suggestion extends Model {
    use HasFactory;
    protected $fillable = [
        "common_name",
        "conservation_status",
        "type",
        "growth_form",
        "leaf_type",
        "leaf_arrangement",
        "fruit_type",
        "root_type",
        "soil",
        "sunlight",
        "water",
        "reproduction",
        "height",
        "locale",
        "habitat",
        "diet",
        "life_span",
        "growth_time",
        "color",
        "toxicity_level",
        "treatment_necessity",
        "description",
        "usageKey",
        "specie_id",
    ];
    public function specie(): BelongsTo {
        return $this->belongsTo(Specie::class);
    }
}
