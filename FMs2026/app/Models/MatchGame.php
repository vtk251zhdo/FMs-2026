<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatchGame extends Model
{
    protected $table = 'Matches';
    protected $primaryKey = 'MatchID';
    public $timestamps = false;

    public function homeClub() {
        return $this->belongsTo(Club::class, 'HomeClubID');
    }

    public function awayClub() {
        return $this->belongsTo(Club::class, 'AwayClubID');
    }

    public function season() {
        return $this->belongsTo(Season::class, 'SeasonID');
    }

    public function stats() {
        return $this->hasMany(MatchStat::class, 'MatchID');
    }
}

