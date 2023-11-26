<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    //FK Comment -> User
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    //FK Comment -> Car
    public function car(): BelongsTo {
        return $this->belongsTo(Car::class);
    }
}
