<?php

namespace Database\Seeders;

use App\Models\GameUser;
use App\Models\Tournament;
use App\Models\Season;
use App\Models\Club;
use App\Models\Player;
use App\Models\Coach;
use App\Models\UserClub;
use App\Models\MatchGame;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Create game users (managers)
        $user1 = GameUser::create([
            'Username' => 'player1',
            'Email' => 'player1@example.com',
            'PasswordHash' => hash('sha256', 'password123'),
            'RegisterDate' => Carbon::now()->subMonths(6),
            'LastLogin' => Carbon::now(),
        ]);

        $user2 = GameUser::create([
            'Username' => 'player2',
            'Email' => 'player2@example.com',
            'PasswordHash' => hash('sha256', 'password123'),
            'RegisterDate' => Carbon::now()->subMonths(3),
            'LastLogin' => Carbon::now(),
        ]);

        // Create tournament
        $tournament = Tournament::create([
            'TournamentName' => 'Ukrainian Premier League 2025-2026',
            'Level' => 'National',
            'Country' => 'Ukraine',
        ]);

        // Create season
        $season = Season::create([
            'TournamentID' => $tournament->TournamentID,
            'StartDate' => Carbon::createFromDate(2025, 8, 1),
            'EndDate' => Carbon::createFromDate(2026, 6, 1),
        ]);

        // Create clubs
        $clubsData = [
            ['ClubName' => 'Dynamo Kyiv', 'City' => 'Kyiv', 'Country' => 'Ukraine', 'Budget' => 50000000, 'Stadium' => 'NSC Olimpiyski'],
            ['ClubName' => 'Shakhtar Donetsk', 'City' => 'Donetsk', 'Country' => 'Ukraine', 'Budget' => 45000000, 'Stadium' => 'Donbas Arena'],
            ['ClubName' => 'Zorya Luhansk', 'City' => 'Luhansk', 'Country' => 'Ukraine', 'Budget' => 25000000, 'Stadium' => 'Slavutych Arena'],
            ['ClubName' => 'Mariupol', 'City' => 'Mariupol', 'Country' => 'Ukraine', 'Budget' => 20000000, 'Stadium' => 'Metalurh Stadium'],
            ['ClubName' => 'Vorskla Poltava', 'City' => 'Poltava', 'Country' => 'Ukraine', 'Budget' => 18000000, 'Stadium' => 'Vorskla Stadium'],
            ['ClubName' => 'Al-Ain FC', 'City' => 'Al-Ain', 'Country' => 'UAE', 'Budget' => 35000000, 'Stadium' => 'Hazza Bin Zayed Stadium'],
        ];

        $clubs = [];
        foreach ($clubsData as $data) {
            $clubs[] = Club::create($data);
        }

        // Assign first two clubs to users
        UserClub::create([
            'UserID' => $user1->UserID,
            'ClubID' => $clubs[0]->ClubID,
            'SeasonID' => $season->SeasonID,
        ]);

        UserClub::create([
            'UserID' => $user2->UserID,
            'ClubID' => $clubs[5]->ClubID,
            'SeasonID' => $season->SeasonID,
        ]);

        // Create players and coaches for each club
        $positions = ['GK', 'CB', 'LB', 'RB', 'CM', 'CAM', 'CDM', 'ST', 'LW', 'RW'];
        $playerNames = [
            'Oleksandr Zinchenko', 'Vitaliy Mykolenko', 'Illia Zabarnyi', 'Mykola Matviyenko', 'Denys Popov',
            'Serhiy Kryvtsov', 'Artim Dzyuba', 'Yehor Sokulskyi', 'Volodymyr Shepelev', 'Ruben Amorim',
            'Heorhiy Sudakov', 'Taras Stepanenko', 'Yarmolenko Andriy', 'Viktor Tsygankov', 'Dodô',
            'Ivan Petriak', 'Vladyslav Supriaha', 'Sergei Krivtsov', 'Anatoliy Trubin', 'Kepa Arrizabalaga',
            'Mohamed Salah', 'Cristiano Ronaldo', 'Kylian Mbappé', 'Robert Lewandowski', 'Erling Haaland',
        ];

        $coachNames = ['Serhiy Rebrov', 'Igor Jovicevic', 'Mircea Lucescu', 'Andriy Shevchenko', 'Paulo Fonseca'];

        foreach ($clubs as $club) {
            // Add 18 players per club
            for ($i = 0; $i < 18; $i++) {
                $position = $positions[$i % count($positions)];
                Player::create([
                    'ClubID' => $club->ClubID,
                    'FullName' => $playerNames[array_rand($playerNames)],
                    'Position' => $position,
                    'Age' => rand(18, 36),
                    'Nationality' => rand(0, 1) ? 'Ukraine' : 'International',
                    'Number' => $i + 1,
                    'Rating' => number_format(rand(65, 95) / 10, 1),
                    'Value' => rand(500000, 50000000),
                ]);
            }

            // Add 3 coaches per club
            for ($i = 0; $i < 3; $i++) {
                Coach::create([
                    'ClubID' => $club->ClubID,
                    'FullName' => $coachNames[array_rand($coachNames)],
                    'Role' => ['Head Coach', 'Assistant Coach', 'Goalkeeper Coach'][$i],
                    'Age' => rand(40, 65),
                ]);
            }
        }

        // Create some matches for the season
        $matchDate = Carbon::createFromDate(2025, 8, 16);
        $matchCounter = 0;

        for ($round = 1; $round <= 5; $round++) {
            for ($i = 0; $i < count($clubs); $i += 2) {
                if ($i + 1 < count($clubs)) {
                    $scoreHome = $matchCounter % 3 == 0 ? rand(0, 5) : 0;
                    $scoreAway = $matchCounter % 3 == 0 ? rand(0, 5) : 0;
                    
                    MatchGame::create([
                        'SeasonID' => $season->SeasonID,
                        'HomeClubID' => $clubs[$i]->ClubID,
                        'AwayClubID' => $clubs[$i + 1]->ClubID,
                        'MatchDate' => $matchDate->copy()->addDays($matchCounter),
                        'Stadium' => $clubs[$i]->Stadium,
                        'ScoreHome' => $scoreHome,
                        'ScoreAway' => $scoreAway,
                    ]);
                    $matchCounter++;
                }
            }
            $matchDate->addDays(7);
        }
    }
}

