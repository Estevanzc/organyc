<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Family extends Model {
    use HasFactory;
    protected $fillable = [
        "name",
        "order_id",
    ];
    public function order(): BelongsTo {
        return $this->belongsTo(Order::class);
    }
    public function genus(): HasMany {
        return $this->hasMany(Genu::class);
    }
}
