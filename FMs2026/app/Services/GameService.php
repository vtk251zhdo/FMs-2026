<?php

namespace App\Services;

use App\Models\MatchGame;
use App\Models\MatchStat;
use App\Models\Player;
use App\Models\Club;
use App\Models\Season;
use App\Models\LeagueTable;
use Illuminate\Support\Collection;

class GameService
{
    /**
     * Simulate a match and generate results
     */
    public static function simulateMatch(MatchGame $match)
    {
        $homeClub = $match->homeClub;
        $awayClub = $match->awayClub;

        // Get squad overall ratings
        $homeRating = $homeClub->players()->avg('Overall') ?? 70;
        $awayRating = $awayClub->players()->avg('Overall') ?? 70;

        // Calculate expected goals based on ratings and randomness
        $homeExpectedGoals = static::calculateExpectedGoals($homeRating, $awayRating);
        $awayExpectedGoals = static::calculateExpectedGoals($awayRating, $homeRating);

        // Generate actual goals with some randomness
        $homeGoals = max(0, $homeExpectedGoals + rand(-2, 2));
        $awayGoals = max(0, $awayExpectedGoals + rand(-2, 2));

        // Update match
        $match->update([
            'HomeGoals' => $homeGoals,
            'AwayGoals' => $awayGoals,
            'Status' => 'Finished',
            'Result' => self::determineResult($homeGoals, $awayGoals),
            'Attendance' => rand(15000, 75000),
            'MatchDate' => now(),
        ]);

        // Generate player stats
        static::generatePlayerStats($match, $homeClub->id, $awayClub->id);

        // Update league table
        static::updateLeagueTable($match);

        return $match;
    }

    /**
     * Calculate expected goals
     */
    private static function calculateExpectedGoals($teamRating, $opponentRating)
    {
        $ratingDifference = $teamRating - $opponentRating;
        $baseGoals = 1.5;
        $modifier = $ratingDifference / 20;

        return max(0, min(5, $baseGoals + $modifier));
    }

    /**
     * Determine match result
     */
    private static function determineResult($homeGoals, $awayGoals)
    {
        if ($homeGoals > $awayGoals) {
            return 'HomeWin';
        } elseif ($awayGoals > $homeGoals) {
            return 'AwayWin';
        }
        return 'Draw';
    }

    /**
     * Generate player stats for a match
     */
    private static function generatePlayerStats(MatchGame $match, $homeClubId, $awayClubId)
    {
        $homeTeam = Player::where('ClubID', $homeClubId)->inRandomOrder()->limit(11)->get();
        $awayTeam = Player::where('ClubID', $awayClubId)->inRandomOrder()->limit(11)->get();

        // Generate home team stats
        foreach ($homeTeam as $player) {
            static::createPlayerStat($match, $player, $match->HomeGoals, $match->AwayGoals, true);
        }

        // Generate away team stats
        foreach ($awayTeam as $player) {
            static::createPlayerStat($match, $player, $match->HomeGoals, $match->AwayGoals, false);
        }
    }

    /**
     * Create individual player stats
     */
    private static function createPlayerStat(MatchGame $match, Player $player, $homeGoals, $awayGoals, $isHome)
    {
        $minutes = rand(60, 90);
        $ratingBase = $player->Overall;

        $goals = 0;
        $assists = 0;
        $shots = rand(0, 5);

        // Forwards more likely to score
        if (in_array($player->Position, ['ST', 'CF', 'LW', 'RW'])) {
            if (rand(1, 100) > 85) {
                $goals = rand(1, 3);
                $shots = rand(3, 8);
            }
        }

        // Midfielders can assist
        if (in_array($player->Position, ['CM', 'CAM', 'LM', 'RM'])) {
            if (rand(1, 100) > 90) {
                $assists = rand(1, 2);
            }
        }

        $rating = min(99, max(40, $ratingBase + rand(-15, 20)));

        MatchStat::create([
            'MatchID' => $match->MatchID,
            'PlayerID' => $player->PlayerID,
            'MinutesPlayed' => $minutes,
            'Goals' => $goals,
            'Assists' => $assists,
            'Shots' => $shots,
            'ShotsOnTarget' => max(0, $shots - rand(0, 3)),
            'Passes' => rand(30, 80),
            'PassAccuracy' => rand(70, 95),
            'Tackles' => rand(0, 8),
            'Interceptions' => rand(0, 5),
            'Fouls' => rand(0, 3),
            'YellowCards' => rand(0, 2) === 0 ? 0 : 1,
            'RedCards' => 0,
            'Rating' => $rating,
        ]);

        // Update player's career stats
        $player->increment('Appearances');
        $player->increment('Goals', $goals);
        $player->increment('Assists', $assists);
    }

    /**
     * Update league table after match
     */
    private static function updateLeagueTable(MatchGame $match)
    {
        $homeEntry = LeagueTable::firstOrCreate(
            ['SeasonID' => $match->SeasonID, 'ClubID' => $match->HomeClubID],
            [
                'Position' => 1,
                'Played' => 0,
                'Wins' => 0,
                'Draws' => 0,
                'Losses' => 0,
                'GoalsFor' => 0,
                'GoalsAgainst' => 0,
                'GoalDifference' => 0,
                'Points' => 0,
            ]
        );

        $awayEntry = LeagueTable::firstOrCreate(
            ['SeasonID' => $match->SeasonID, 'ClubID' => $match->AwayClubID],
            [
                'Position' => 1,
                'Played' => 0,
                'Wins' => 0,
                'Draws' => 0,
                'Losses' => 0,
                'GoalsFor' => 0,
                'GoalsAgainst' => 0,
                'GoalDifference' => 0,
                'Points' => 0,
            ]
        );

        // Update home team
        $homeEntry->increment('Played');
        $homeEntry->increment('GoalsFor', $match->HomeGoals);
        $homeEntry->increment('GoalsAgainst', $match->AwayGoals);

        if ($match->Result === 'HomeWin') {
            $homeEntry->increment('Wins');
            $homeEntry->increment('Points', 3);
        } elseif ($match->Result === 'Draw') {
            $homeEntry->increment('Draws');
            $homeEntry->increment('Points', 1);
        } else {
            $homeEntry->increment('Losses');
        }

        // Update away team
        $awayEntry->increment('Played');
        $awayEntry->increment('GoalsFor', $match->AwayGoals);
        $awayEntry->increment('GoalsAgainst', $match->HomeGoals);

        if ($match->Result === 'AwayWin') {
            $awayEntry->increment('Wins');
            $awayEntry->increment('Points', 3);
        } elseif ($match->Result === 'Draw') {
            $awayEntry->increment('Draws');
            $awayEntry->increment('Points', 1);
        } else {
            $awayEntry->increment('Losses');
        }

        // Update goal differences
        $homeEntry->update(['GoalDifference' => $homeEntry->GoalsFor - $homeEntry->GoalsAgainst]);
        $awayEntry->update(['GoalDifference' => $awayEntry->GoalsFor - $awayEntry->GoalsAgainst]);
    }

    /**
     * Advance season to next round
     */
    public static function advanceSeason(Season $season)
    {
        $season->increment('CurrentRound');

        if ($season->CurrentRound > $season->TotalRounds) {
            $season->update(['EndDate' => now()]);
            return 'ended';
        }

        return 'advanced';
    }

    /**
     * Generate season schedule
     */
    public static function generateSchedule(Season $season)
    {
        $clubs = Club::all();
        $round = 1;
        $matches = [];

        // Round-robin tournament
        for ($matchDay = 1; $matchDay <= $season->TotalRounds; $matchDay++) {
            $matchesThisRound = [];

            for ($i = 0; $i < count($clubs); $i += 2) {
                if ($i + 1 < count($clubs)) {
                    $matchesThisRound[] = [
                        'SeasonID' => $season->SeasonID,
                        'HomeClubID' => $clubs[$i]->ClubID,
                        'AwayClubID' => $clubs[$i + 1]->ClubID,
                        'Round' => $matchDay,
                        'Status' => 'Scheduled',
                        'Result' => 'Pending',
                    ];
                }
            }

            $matches = array_merge($matches, $matchesThisRound);
        }

        MatchGame::insert($matches);
    }
}
