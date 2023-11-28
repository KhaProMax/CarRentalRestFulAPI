<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Model
{
    use HasFactory;

    protected $table = 'user';

    protected $fillable = ['USER_ID', 'PASSWORD','FIRST_NAME', 'LAST_NAME', 'DOB', 'GENDER', 'SDT', 'EMAIL', 'GPLX'];
    protected $hidden = ['PASSWORD'];
    // test
    //test 11111111

    // FK Contract -> User
    public function contract(): HasOne { 
        return $this->hasOne( Contract::class);
    }

    // FK Car -> User
    public function car(): HasOne {
        return $this->hasOne(Car::class);
    }

    // FK Owner -> User
    public function car_owner(): HasOne { 
        return $this->hasOne(CarOwner::class);
    }

    //FK Comment-> Userds
    public function comment(): HasOne {
        return $this->hasOne(Comment::class);
    }
}
