<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserClub;
use App\Models\MatchGame;
use App\Models\Club;

class MatchController extends Controller
{
    /**
     * Show upcoming matches
     */
    public function fixtures()
    {
        $userClub = UserClub::with(['club', 'season'])->first();
        
        if (!$userClub) {
            return redirect()->route('dashboard');
        }

        $season = $userClub->season;

        $upcomingMatches = MatchGame::where('SeasonID', $season->SeasonID)
            ->with(['homeClub', 'awayClub'])
            ->whereNull('ScoreHome')
            ->orderBy('MatchDate', 'asc')
            ->get();

        return view('matches.fixtures', [
            'matches' => $upcomingMatches,
            'season' => $season,
        ]);
    }

    /**
     * Show completed matches
     */
    public function results()
    {
        $userClub = UserClub::with(['club', 'season'])->first();
        
        if (!$userClub) {
            return redirect()->route('dashboard');
        }

        $season = $userClub->season;

        $results = MatchGame::where('SeasonID', $season->SeasonID)
            ->with(['homeClub', 'awayClub'])
            ->whereNotNull('ScoreHome')
            ->orderBy('MatchDate', 'desc')
            ->get();

        return view('matches.results', [
            'matches' => $results,
        ]);
    }

    /**
     * Show match details with statistics
     */
    public function detail($id)
    {
        $match = MatchGame::with(['homeClub', 'awayClub', 'stats.player'])->findOrFail($id);
        $stats = $match->stats()->where('PlayerID', '!=', null)->get();

        return view('matches.detail', [
            'match' => $match,
            'stats' => $stats,
        ]);
    }

    /**
     * Get league table
     */
    public function leagueTable()
    {
        $userClub = UserClub::with(['club', 'season'])->first();
        
        if (!$userClub) {
            return redirect()->route('dashboard');
        }

        $season = $userClub->season;

        // Calculate league table
        $table = Club::get()
        ->map(function ($club) use ($season) {
            $matches = MatchGame::where('SeasonID', $season->SeasonID)
                ->where(function ($q) use ($club) {
                    $q->where('HomeClubID', $club->ClubID)
                      ->orWhere('AwayClubID', $club->ClubID);
                })
                ->whereNotNull('ScoreHome')
                ->get();

            $points = 0;
            $gf = 0;
            $ga = 0;
            $w = $d = $l = 0;

            foreach ($matches as $match) {
                if ($match->HomeClubID === $club->ClubID) {
                    $gf += $match->ScoreHome;
                    $ga += $match->ScoreAway;
                    if ($match->ScoreHome > $match->ScoreAway) {
                        $points += 3;
                        $w++;
                    } elseif ($match->ScoreHome === $match->ScoreAway) {
                        $points += 1;
                        $d++;
                    } else {
                        $l++;
                    }
                } else {
                    $gf += $match->ScoreAway;
                    $ga += $match->ScoreHome;
                    if ($match->ScoreAway > $match->ScoreHome) {
                        $points += 3;
                        $w++;
                    } elseif ($match->ScoreAway === $match->ScoreHome) {
                        $points += 1;
                        $d++;
                    } else {
                        $l++;
                    }
                }
            }

            return [
                'club' => $club,
                'matches' => count($matches),
                'wins' => $w,
                'draws' => $d,
                'losses' => $l,
                'gf' => $gf,
                'ga' => $ga,
                'gd' => $gf - $ga,
                'points' => $points,
            ];
        })
        ->sortByDesc('points')
        ->sortByDesc('gd')
        ->values();

        return view('matches.league-table', [
            'table' => $table,
            'season' => $season,
        ]);
    }
}
