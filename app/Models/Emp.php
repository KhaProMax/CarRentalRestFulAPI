<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emp extends Model
{
    use HasFactory;

    protected $table = 'emp';

    protected $fillable = [
        'USERNAME', 'PASSWORD', 'F_NAME', 'L_NAME', 'PHONE', 'EMAIL', 'ROLE'
    ];

    public $incrementing = false;
    public $timestamps = false;
}
