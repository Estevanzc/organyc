<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kingdom extends Model {
    use HasFactory;
    protected $fillable = [
        "name",
        "domain_id",
    ];
    public function domain(): BelongsTo {
        return $this->belongsTo(Domain::class);
    }
    public function phylums(): HasMany {
        return $this->hasMany(Phylum::class);
    }
}
