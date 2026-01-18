<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Club;
use App\Models\UserClub;

class ClubController extends Controller
{

    public function overview()
    {
        $userClub = UserClub::with(['club', 'season'])->first();
        
        if (!$userClub) {
            return redirect()->route('dashboard');
        }

        $club = $userClub->club;

        return view('clubs.overview', [
            'club' => $club,
            'userClub' => $userClub,
            'players' => $club->players()->get(),
            'coaches' => $club->coaches()->get(),
        ]);
    }

    public function players()
    {
        $userClub = UserClub::with(['club', 'season'])->first();
        
        if (!$userClub) {
            return redirect()->route('dashboard');
        }

        $club = $userClub->club;
        $players = $club->players()->orderBy('Rating', 'desc')->get();

        return view('clubs.players', [
            'club' => $club,
            'players' => $players,
        ]);
    }

    public function playerDetail($id)
    {
        $userClub = UserClub::with(['club', 'season'])->first();
        
        if (!$userClub) {
            return redirect()->route('dashboard');
        }

        $player = $userClub->club->players()->findOrFail($id);

        return view('clubs.player-detail', [
            'player' => $player,
            'club' => $userClub->club,
        ]);
    }

    public function coaches()
    {
        $userClub = UserClub::with(['club', 'season'])->first();
        
        if (!$userClub) {
            return redirect()->route('dashboard');
        }

        $club = $userClub->club;
        $coaches = $club->coaches()->get();

        return view('clubs.coaches', [
            'club' => $club,
            'coaches' => $coaches,
        ]);
    }

    public function facilities()
    {
        $userClub = UserClub::with(['club', 'season'])->first();
        
        if (!$userClub) {
            return redirect()->route('dashboard');
        }

        return view('clubs.facilities', [
            'club' => $userClub->club,
        ]);
    }
}