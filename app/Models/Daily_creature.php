<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Daily_creature extends Model {
    use HasFactory;
    protected $fillable = [
        "creature_id",
        "is_plant",
    ];
}
