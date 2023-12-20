<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class owner_revenue extends Model
{
    use HasFactory;
    protected $table = 'owner_revenue';

    protected $fillable = ['OWNER_ID', 'DATE_REVN', 'REVENUE', 'PROFIT', 'NUM_OF_CLIENTS'];

    public $incrementing = false;
    public $timestamps = false;  

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'OWNER_ID', 'USER_ID');
    }
}


