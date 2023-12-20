<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarOwner extends Model
{
    use HasFactory;

    protected $table = 'carowner';

    protected $fillable = ['OWNER_ID', 'LICENSE_PLATE'];

    public $incrementing = false;
    public $timestamps = false;

    // FK Owner -> User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'OWNER_ID', 'USER_ID');
    }

    // FK Onwer -> Car
    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class, 'LICENSE_PLATE');
    }
}
