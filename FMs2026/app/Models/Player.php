<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $table = 'Players';
    protected $primaryKey = 'PlayerID';
    public $timestamps = false;

    protected $fillable = [
        'FullName','Age','Position','Nationality',
        'Number','Rating','Value','ClubID'
    ];

    public function club() {
        return $this->belongsTo(Club::class, 'ClubID');
    }

    public function stats() {
        return $this->hasMany(MatchStat::class, 'PlayerID');
    }

    public function transfers() {
        return $this->hasMany(Transfer::class, 'PlayerID');
    }
}

