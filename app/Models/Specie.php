<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
}
