<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserClub extends Model
{
    protected $table = 'UserClubs';
    protected $primaryKey = 'UserClubID';
    public $timestamps = false;

    protected $fillable = [
        'UserID',
        'ClubID',
        'SeasonID',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(GameUser::class, 'UserID');
    }

    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class, 'ClubID');
    }

    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class, 'SeasonID');
    }
}


