<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [];

    // FK Contract -> User
    public function user() {
        return $this->belongsTo(User::class);
    }

    // FK Contract -> Car
    public function car() {
        return $this->belongsTo(Car::class);
    }
}
