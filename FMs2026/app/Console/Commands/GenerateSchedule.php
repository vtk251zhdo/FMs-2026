<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Season;
use App\Models\Club;
use App\Services\GameService;

class GenerateSchedule extends Command
{
    protected $signature = 'game:generate-schedule {season_id?}';
    protected $description = 'Generate match schedule for a season';

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

        $this->info("Generating schedule for season {$season->SeasonYear}...");

        GameService::generateSchedule($season);
        
        $totalMatches = $season->matches()->count();
        $this->info("✓ Schedule generated! Total matches: {$totalMatches}");

        return 0;
    }
}
