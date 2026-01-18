<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeagueTable extends Model
{
    protected $table = 'LeagueTable';
    protected $primaryKey = 'TableID';
    public $timestamps = false;

    protected $fillable = [
        'SeasonID',
        'ClubID',
        'Position',
        'Played',
        'Wins',
        'Draws',
        'Losses',
        'GoalsFor',
        'GoalsAgainst',
        'GoalDifference',
        'Points',
    ];

    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class, 'SeasonID');
    }

    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class, 'ClubID');
    }
}
