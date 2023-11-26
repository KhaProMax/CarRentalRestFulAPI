<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarFeature extends Model
{
    use HasFactory;


    // FK CarFeature -> Car
    public function car(): BelongsTo{
        return $this->belongsTo(Car::class);
    }
}
