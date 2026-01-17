<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tournament extends Model
{
    protected $table = 'Tournaments';
    protected $primaryKey = 'TournamentID';
    public $timestamps = false;

    protected $fillable = [
        'TournamentName',
        'Level',
        'Country',
    ];

    public function seasons(): HasMany
    {
        return $this->hasMany(Season::class, 'TournamentID');
    }
}

