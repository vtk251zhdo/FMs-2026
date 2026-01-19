<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GameUser extends Model
{
    protected $table = 'GameUsers';
    protected $primaryKey = 'UserID';
    public $timestamps = false;

    protected $hidden = ['PasswordHash'];

    protected $fillable = [
        'Username',
        'Email',
        'PasswordHash',
        'RegisterDate',
        'LastLogin',
        'role',
    ];

    protected $casts = [
        'RegisterDate' => 'date',
        'LastLogin' => 'datetime',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPlayer(): bool
    {
        return $this->role === 'player';
    }

    public function userClubs(): HasMany
    {
        return $this->hasMany(UserClub::class, 'UserID');
    }

    public function activeCareer()
    {
        return $this->userClubs()
            ->with(['club', 'season'])
            ->first();
    }
}


