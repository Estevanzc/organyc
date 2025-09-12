<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model {
    use HasFactory;
    protected $fillable = [
        "name",
        "class_id",
    ];
    public function class(): BelongsTo {
        return $this->belongsTo(Clas::class);
    }
    public function families(): HasMany {
        return $this->hasMany(Family::class);
    }
}
