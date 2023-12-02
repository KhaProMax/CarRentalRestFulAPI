<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Car extends Model
{
    use HasFactory;

    protected $table = 'car';
    protected $fillable = [
        'LICENSE_PLATE',
        'OWNER_ID' ,
        'NAME',
        'LOCATION',
        'LAST_CHECK',
        'BRAND',
        'SEAT',
        'TRANSMISSION',
        'FUEL',
        'CONSUMPTION',
        'PRICE',
        'SERVICE_FEE',
        'INSURANCE_FEE',
        'DESCRIPTION',
    ];
    
    public $incrementing = false;
    public $timestamps = false;

    //FK CarFeature -> Car
    public function car_feature(): HasOne {
        return $this->hasOne(CarFeature::class);
    }
}
