<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Phylum extends Model {
    use HasFactory;
    protected $fillable = [
        "name",
        "kingdom_id",
    ];
    public function kingdom(): BelongsTo {
        return $this->belongsTo(Kingdom::class);
    }
    public function classes(): HasMany {
        return $this->hasMany(Clas::class);
    }
}
