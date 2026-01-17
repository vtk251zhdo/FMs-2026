<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Coach extends Model
{
    protected $table = 'Coaches';
    protected $primaryKey = 'CoachID';
    public $timestamps = false;

    protected $fillable = [
        'FullName',
        'Role',
        'Age',
        'ClubID',
    ];

    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class, 'ClubID');
    }
}


