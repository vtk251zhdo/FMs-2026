<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MatchStat extends Model
{
    protected $table = 'MatchStats';
    protected $primaryKey = 'StatID';
    public $timestamps = false;

    protected $fillable = [
        'MatchID',
        'PlayerID',
        'Goals',
        'Assists',
        'YellowCards',
        'RedCards',
        'Rating',
    ];

    public function match(): BelongsTo
    {
        return $this->belongsTo(MatchGame::class, 'MatchID');
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'PlayerID');
    }
}

