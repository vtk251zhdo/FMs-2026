<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    protected $table = 'Seasons';
    protected $primaryKey = 'SeasonID';
    public $timestamps = false;

    public function tournament() {
        return $this->belongsTo(Tournament::class, 'TournamentID');
    }

    public function matches() {
        return $this->hasMany(MatchGame::class, 'SeasonID');
    }
}

