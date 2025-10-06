<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Animal_report extends Model {
    protected $fillable = [
        "description",
        "animal_id",
    ];
    public function plant(): BelongsTo {
        return $this->belongsTo(Animal::class);
    }
}
