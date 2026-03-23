<?php

namespace App\Http\Controllers;

use App\Services\ClubService;

class ClubController extends Controller
{
    public function __construct(private ClubService $clubService)
    {
    }

    public function overview()
    {
        $userClub = $this->clubService->getUserClub();

        if (!$userClub) {
            return redirect()->route('dashboard');
        }

        return view('clubs.overview', [
            'club' => $userClub->club,
            'userClub' => $userClub,
            'players' => $this->clubService->getPlayers($userClub->club),
            'coaches' => $this->clubService->getCoaches($userClub->club),
        ]);
    }

    public function players()
    {
        $userClub = $this->clubService->getUserClub();

        if (!$userClub) {
            return redirect()->route('dashboard');
        }

        return view('clubs.players', [
            'club' => $userClub->club,
            'players' => $this->clubService->getPlayersOrderedByRating($userClub->club),
        ]);
    }

    public function playerDetail($id)
    {
        $userClub = $this->clubService->getUserClub();

        if (!$userClub) {
            return redirect()->route('dashboard');
        }

        return view('clubs.player-detail', [
            'player' => $this->clubService->getPlayerById($userClub->club, $id),
            'club' => $userClub->club,
        ]);
    }

    public function coaches()
    {
        $userClub = $this->clubService->getUserClub();

        if (!$userClub) {
            return redirect()->route('dashboard');
        }

        return view('clubs.coaches', [
            'club' => $userClub->club,
            'coaches' => $this->clubService->getCoaches($userClub->club),
        ]);
    }

    public function facilities()
    {
        $userClub = $this->clubService->getUserClub();

        if (!$userClub) {
            return redirect()->route('dashboard');
        }

        return view('clubs.facilities', [
            'club' => $userClub->club,
        ]);
    }
}
