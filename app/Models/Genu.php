<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Genu extends Model {
    use HasFactory;
    protected $fillable = [
        "name",
        "family_id",
    ];
    public function family(): BelongsTo {
        return $this->belongsTo(Family::class);
    }
    public function species(): HasMany {
        return $this->hasMany(Specie::class);
    }
}
