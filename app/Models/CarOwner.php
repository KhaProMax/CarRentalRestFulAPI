<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarOwner extends Model
{
    use HasFactory;

    //FK Car owner -> User
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
