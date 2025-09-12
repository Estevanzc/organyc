<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plant_photo extends Model {
    use HasFactory;
    protected $fillable = [
        "photo",
        "plant_id",
    ];
    public function photos(): HasMany {
        return $this->hasMany(Plant_photo::class);
    }
}
