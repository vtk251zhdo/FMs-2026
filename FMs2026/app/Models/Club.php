<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    protected $table = 'Clubs';
    protected $primaryKey = 'ClubID';
    public $timestamps = false;

    public function players() {
        return $this->hasMany(Player::class, 'ClubID');
    }

    public function coaches() {
        return $this->hasMany(Coach::class, 'ClubID');
    }

    public function homeMatches() {
        return $this->hasMany(MatchGame::class, 'HomeClubID');
    }

    public function awayMatches() {
        return $this->hasMany(MatchGame::class, 'AwayClubID');
    }
}

