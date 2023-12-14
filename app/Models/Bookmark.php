<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bookmark extends Model
{
    use HasFactory;
    protected $table = "bookmark";
    protected $fillable = ['USER_ID', 'LICENSE_PLATE'];

    public $incrementing = false;
    public $timestamps = false;

    // FK Contract -> User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'USER_ID');
    }

    // FK Contract -> Car
    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class, 'LICENSE_PLATE');
    }
}
