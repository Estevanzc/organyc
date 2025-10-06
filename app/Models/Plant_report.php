<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Plant_report extends Model {
    protected $fillable = [
        "description",
        "plant_id",
    ];
    public function plant(): BelongsTo {
        return $this->belongsTo(Plant::class);
    }
}
