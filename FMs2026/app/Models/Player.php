<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Player extends Model
{
    protected $table = 'Players';
    protected $primaryKey = 'PlayerID';
    public $timestamps = false;

    protected $fillable = [
        'FullName',
        'Age',
        'Position',
        'Nationality',
        'Number',
        'Rating',
        'Value',
        'ClubID',
        'Appearances',
        'Goals',
        'Assists',
    ];

    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class, 'ClubID');
    }

    public function stats(): HasMany
    {
        return $this->hasMany(MatchStat::class, 'PlayerID');
    }

    public function transfers(): HasMany
    {
        return $this->hasMany(Transfer::class, 'PlayerID');
    }

    public function getGoalsCount()
    {
        return $this->stats()->sum('Goals');
    }

    public function getAssistsCount()
    {
        return $this->stats()->sum('Assists');
    }

    public function getAverageRating()
    {
        return round($this->stats()->avg('Rating') ?? 0, 2);
    }
}



