<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transfer extends Model
{
    protected $table = 'Transfers';
    protected $primaryKey = 'TransferID';
    public $timestamps = false;

    protected $fillable = [
        'PlayerID',
        'FromClubID',
        'ToClubID',
        'TransferFee',
        'TransferDate',
    ];

    protected $casts = [
        'TransferDate' => 'date',
    ];

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'PlayerID');
    }

    public function fromClub(): BelongsTo
    {
        return $this->belongsTo(Club::class, 'FromClubID');
    }

    public function toClub(): BelongsTo
    {
        return $this->belongsTo(Club::class, 'ToClubID');
    }
}

