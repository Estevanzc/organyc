<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Daily_creature extends Model {
    protected $fillable = [
        "creature_id",
        "is_plant",
    ];
}
