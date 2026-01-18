<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MatchGame extends Model
{
    protected $table = 'Matches';
    protected $primaryKey = 'MatchID';
    public $timestamps = false;

    protected $fillable = [
        'SeasonID',
        'HomeClubID',
        'AwayClubID',
        'MatchDate',
        'Stadium',
        'ScoreHome',
        'ScoreAway',
        'Status',
        'Result',
        'Attendance',
        'Round',
    ];

    protected $casts = [
        'MatchDate' => 'datetime',
    ];

    public function getStatusText(): string
    {
        return match($this->Status) {
            'Finished' => 'Завершено',
            'Scheduled' => 'Запланована',
            'Live' => 'Йде матч',
            default => $this->Status,
        };
    }

    public function homeClub(): BelongsTo
    {
        return $this->belongsTo(Club::class, 'HomeClubID');
    }

    public function awayClub(): BelongsTo
    {
        return $this->belongsTo(Club::class, 'AwayClubID');
    }

    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class, 'SeasonID');
    }

    public function stats(): HasMany
    {
        return $this->hasMany(MatchStat::class, 'MatchID');
    }

    public function getResult()
    {
        if ($this->ScoreHome > $this->ScoreAway) {
            return 'HomeWin';
        } elseif ($this->ScoreAway > $this->ScoreHome) {
            return 'AwayWin';
        }
        return 'Draw';
    }

    public function getResultText()
    {
        return "{$this->ScoreHome}:{$this->ScoreAway}";
    }
}



