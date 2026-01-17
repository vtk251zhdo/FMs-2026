<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Season;
use App\Models\MatchGame;
use App\Services\GameService;

class SimulateMatches extends Command
{
    protected $signature = 'game:simulate-matches {season_id?}';
    protected $description = 'Simulate all matches in the current round of a season';

    public function handle()
    {
        $seasonId = $this->argument('season_id');

        if (!$seasonId) {
            $season = Season::whereNull('EndDate')->first();
            if (!$season) {
                $this->error('No active season found!');
                return 1;
            }
        } else {
            $season = Season::find($seasonId);
            if (!$season) {
                $this->error("Season with ID {$seasonId} not found!");
                return 1;
            }
        }

        $this->info("Simulating matches for season: {$season->SeasonYear} (Round {$season->CurrentRound})");

        // Get matches for current round
        $matches = MatchGame::where('SeasonID', $season->SeasonID)
            ->where('Round', $season->CurrentRound)
            ->where('Status', 'Scheduled')
            ->get();

        if ($matches->isEmpty()) {
            $this->warn('No scheduled matches found for this round!');
            return 0;
        }

        $this->info("Found {$matches->count()} matches. Simulating...");

        foreach ($matches as $match) {
            GameService::simulateMatch($match);
            $this->line("✓ {$match->homeClub->Name} {$match->HomeGoals}:{$match->AwayGoals} {$match->awayClub->Name}");
        }

        // Advance to next round
        GameService::advanceSeason($season);
        $this->info("✓ Season advanced to round " . $season->CurrentRound);

        return 0;
    }
}
