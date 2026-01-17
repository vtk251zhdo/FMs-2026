<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Club extends Model
{
    protected $table = 'Clubs';
    protected $primaryKey = 'ClubID';
    public $timestamps = false;

    protected $fillable = [
        'ClubName',
        'Country',
        'City',
        'Budget',
        'Stadium',
    ];

    public function players(): HasMany
    {
        return $this->hasMany(Player::class, 'ClubID');
    }

    public function coaches(): HasMany
    {
        return $this->hasMany(Coach::class, 'ClubID');
    }

    public function homeMatches(): HasMany
    {
        return $this->hasMany(MatchGame::class, 'HomeClubID');
    }

    public function awayMatches(): HasMany
    {
        return $this->hasMany(MatchGame::class, 'AwayClubID');
    }

    public function userClubs(): HasMany
    {
        return $this->hasMany(UserClub::class, 'ClubID');
    }

    public function getAverageRating()
    {
        return round($this->players()->avg('Rating') ?? 0, 2);
    }

    public function getTotalSquadValue()
    {
        return $this->players()->sum('Value');
    }
}



