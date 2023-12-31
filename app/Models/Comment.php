<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $table = "comment";
    protected $fillable = ['USER_ID', 'LICENSE_PLATE', 'COMM_DATE', 'REVIEW', 'COMMENT'];
    public $incrementing = false;
    public $timestamps = false;

    // FK Comment -> User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'USER_ID');
    }

    // FK Comment -> Car
    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class, 'LICENSE_PLATE');
    }
}
