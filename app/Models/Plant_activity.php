<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Plant_activity extends Model {
    protected $fillable = [
        "plant_id",
        "user_id",
    ];
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
    public function plant(): BelongsTo {
        return $this->belongsTo(Plant::class);
    }
}
