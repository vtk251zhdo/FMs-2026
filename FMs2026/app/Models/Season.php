<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Season extends Model
{
    protected $table = 'Seasons';
    protected $primaryKey = 'SeasonID';
    public $timestamps = false;

    protected $fillable = [
        'TournamentID',
        'StartDate',
        'EndDate',
        'TotalRounds',
        'CurrentRound',
    ];

    protected $casts = [
        'StartDate' => 'date',
        'EndDate' => 'date',
    ];

    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class, 'TournamentID');
    }

    public function userClubs(): HasMany
    {
        return $this->hasMany(UserClub::class, 'SeasonID');
    }

    public function matches(): HasMany
    {
        return $this->hasMany(MatchGame::class, 'SeasonID');
    }
}


