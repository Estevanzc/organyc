<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Animal_activity extends Model {
    protected $fillable = [
        "animal_id",
        "user_id",
    ];
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
    public function animal(): BelongsTo {
        return $this->belongsTo(Animal::class);
    }
}
