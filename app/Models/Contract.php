<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Contract extends Pivot
{
    use HasFactory;

    protected $table = 'contract';

    protected $primaryKey = 'CONTRACT_ID';

    protected $fillable = ['CONTRACT_ID', 'USER_ID', 'LICENSE_PLATE', 'START_DATE', 'END_DATE', 'DEPOSIT_STATUS', 'RETURN_STATUS'];

    public $incrementing = false;
    public $timestamps = false;

    public static function generateUniqueId()
    {
        return "ctr" . time();
    }

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
