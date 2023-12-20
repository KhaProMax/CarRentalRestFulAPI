<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Car extends Model
{
    use HasFactory;

    protected $table = 'car';
    protected $primaryKey = 'LICENSE_PLATE';
    protected $fillable = [
        'LICENSE_PLATE', 'OWNER_ID', 'NAME', 'LOCATION', 'LAST_CHECK', 'BRAND', 'SEAT', 'TRANSMISSION', 'FUEL', 'CONSUMPTION', 'PRICE', 'SERVICE_FEE', 'INSURANCE_FEE', 'DESCRIPTION', 'MAP', 'BLUETOOTH', 'CAMERA_360', 'CAMERA_SIDES', 'CAMERA_JOURNEY', 'CAMERA_BACK', 'TIRE_SENSOR', 'IMPACT_SENSOR', 'SPEED_WARNING', 'SKY_WINDOW', 'GPS', 'CHILD_SEAT', 'USB', 'SPARE_TIRE', 'DVD', 'ETC', 'AIRBAG', 'PICKUP_COVER', 'FRONT_IMG', 'BACK_IMG', 'LEFT_IMG', 'RIGHT_IMG'
    ];

    public $incrementing = false;
    public $timestamps = false;

    public static function generateUniqueId()
    {
        return "car" . time();
    }

    public static function isAvailable($start_date, $end_date)
    {
        $currentTime = Carbon::now();
        $startTime = Carbon::parse($start_date);
        $endTime = Carbon::parse($end_date);
        return !$currentTime->between($startTime, $endTime);
    }


    // FK Contract -> Car
    public function contract(): HasMany {
        return $this->hasMany(Contract::class, 'LICENSE_PLATE', 'LICENSE_PLATE');
    }

    // FK Bookmark -> Car
    public function bookmark(): HasMany {
        return $this->hasMany(Contract::class, 'LICENSE_PLATE', 'LICENSE_PLATE');
    }

    // FK Car -> User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'OWNER_ID', 'USER_ID');
    }

    // FK CarOnwer -> Car
    public function carowner(): HasOne { 
        return $this->hasOne(CarOwner::class);
    }

    // FK Comment -> Car
    public function comment(): HasMany {
        return $this->hasMany(Comment::class, 'LICENSE_PLATE', 'LICENSE_PLATE');
    }
}
