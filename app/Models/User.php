<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Model
{
    use HasFactory;

    protected $table = 'user';

    protected $primaryKey = 'USER_ID';

    protected $fillable = ['USER_ID', 'PASSWORD','FIRST_NAME', 'LAST_NAME', 'DOB', 'GENDER', 'SDT', 'EMAIL', 'GPLX'];
    // protected $hidden = ['PASSWORD'];

    public $incrementing = false;
    public $timestamps = false;

    public static function generateUniqueId()
    {
        return "user" . time();
    }

    public function hasLicense() {
        return $this->GPLX == null;
    }

    // FK Contract -> User
    public function contract(): HasMany {
        return $this->hasMany(Contract::class);
    }

    // FK Bookmark -> User
    public function bookmark(): HasMany {
        return $this->hasMany(Bookmark::class);
    }

    // FK Comment -> User
    public function comment(): HasMany {
        return $this->hasMany(Comment::class);
    }

    // FK Car -> User
    public function car(): HasMany {
        return $this->hasMany(Car::class);
    }
}
