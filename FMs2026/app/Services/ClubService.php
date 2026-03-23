<?php

namespace App\Services;

use App\Models\Club;
use App\Models\UserClub;

class ClubService
{
    public function getUserClub()
    {
        return UserClub::with(['club', 'season'])->first();
    }

    public function getPlayers(Club $club)
    {
        return $club->players()->get();
    }

    public function getPlayersOrderedByRating(Club $club)
    {
        return $club->players()->orderBy('Rating', 'desc')->get();
    }

    public function getPlayerById(Club $club, int $id)
    {
        return $club->players()->findOrFail($id);
    }

    public function getCoaches(Club $club)
    {
        return $club->coaches()->get();
    }
}
