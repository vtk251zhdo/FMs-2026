<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameUser extends Model
{
    protected $table = 'GameUsers';
    protected $primaryKey = 'UserID';
    public $timestamps = false;

    protected $hidden = ['PasswordHash'];

    public function clubs() {
        return $this->hasMany(UserClub::class, 'UserID');
    }
}

