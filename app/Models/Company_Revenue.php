<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company_Revenue extends Model
{
    use HasFactory;

    protected $table = 'company_revenue';

    protected $fillable = [
        'DATE_REVN', 'REVENUE', 'PROFIT', 'NUM_OF_CLIENTS'
    ];

    public $incrementing = false;
    public $timestamps = false;
}
