<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\LocalizationController;

use App\Models\Season;
use App\Models\Club;
use App\Models\UserClub;
use App\Models\Tournament;
use App\Models\MatchGame;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/
Route::view('/', 'home')->name('home');

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Localization
|--------------------------------------------------------------------------
*/
Route::middleware(['web'])->group(function () {
    Route::post('/set-language/{language}', [LocalizationController::class, 'setLanguage'])->name('set-language');
    Route::get('/get-language', [LocalizationController::class, 'getLanguage'])->name('get-language');
});

/*
|--------------------------------------------------------------------------
| Start Game / Career
|--------------------------------------------------------------------------
*/
Route::get('/start-game', function () {

    if (!session()->has('user_id')) {
        return redirect()->route('login');
    }

    // Якщо вже є активна карʼєра (Season без EndDate)
    $activeCareer = UserClub::where('UserID', session('user_id'))
        ->whereHas('season', fn($q) => $q->where('EndDate', '>', now()))
        ->first();

    if ($activeCareer) {
        return redirect()->route('dashboard');
    }

    $clubs = Club::orderBy('ClubName')->get();

    return view('start-game', compact('clubs'));
})->name('start-game');


Route::post('/start-game', function (Request $request) {

    if (!session()->has('user_id')) {
        return redirect()->route('login');
    }

    $request->validate([
        'club_id' => 'required|exists:Clubs,ClubID'
    ]);

    // Турнір за замовчуванням (УПЛ)
    $tournament = Tournament::firstOrFail();

    // 🔥 СТВОРЮЄМО НОВУ КАРʼЄРУ (Season)
    $season = Season::create([
        'TournamentID' => $tournament->TournamentID,
        'StartDate' => now(),
        'EndDate' => now()->addMonths(10),
        'CurrentRound' => 1,
        'TotalRounds' => 30
    ]);

    // Привʼязка менеджера до клубу і сезону
    UserClub::create([
        'UserID' => session('user_id'),
        'ClubID' => $request->club_id,
        'SeasonID' => $season->SeasonID
    ]);

    return redirect()->route('dashboard');
});

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {

    if (!session()->has('user_id')) {
        return redirect()->route('login');
    }

    $career = UserClub::with(['club', 'season'])
        ->where('UserID', session('user_id'))
        ->first();

    if (!$career) {
        return redirect()->route('start-game');
    }

    // Get upcoming matches
    $upcomingMatches = MatchGame::with(['homeClub', 'awayClub'])
        ->orderBy('MatchDate', 'asc')
        ->limit(1)
        ->get();

    return view('dashboard', compact('career', 'upcomingMatches'));
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| Game Routes (Protected)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth.session'])->group(function () {

    /*
    | Club
    */
    Route::prefix('club')->group(function () {
        Route::get('/overview', [ClubController::class, 'overview'])->name('club.overview');
        Route::get('/players', [ClubController::class, 'players'])->name('club.players');
        Route::get('/player/{id}', [ClubController::class, 'playerDetail'])->name('club.player');
        Route::get('/coaches', [ClubController::class, 'coaches'])->name('club.coaches');
        Route::get('/facilities', [ClubController::class, 'facilities'])->name('club.facilities');
    });

    /*
    | Matches
    */
    Route::prefix('matches')->group(function () {
        Route::get('/fixtures', [MatchController::class, 'fixtures'])->name('matches.fixtures');
        Route::get('/results', [MatchController::class, 'results'])->name('matches.results');
        Route::get('/detail/{id}', [MatchController::class, 'detail'])->name('matches.detail');
        Route::get('/league-table', [MatchController::class, 'leagueTable'])->name('matches.league-table');
    });

    /*
    | Transfers
    */
    Route::prefix('transfers')->group(function () {
        Route::get('/market', [TransferController::class, 'market'])->name('transfers.market');
        Route::get('/sell', [TransferController::class, 'sellPlayers'])->name('transfers.sell');
        Route::post('/buy/{id}', [TransferController::class, 'makeOffer'])->name('transfers.buy');
        Route::post('/sell/{id}', [TransferController::class, 'sellPlayer'])->name('transfers.sell-player');
        Route::get('/history', [TransferController::class, 'history'])->name('transfers.history');
    });

    /*
    | Finances
    */
    Route::prefix('finances')->group(function () {
        Route::get('/', [FinanceController::class, 'index'])->name('finances.index');
        Route::get('/budget', [FinanceController::class, 'budget'])->name('finances.budget');
    });
});

/*
|--------------------------------------------------------------------------
| Placeholder / Static
|--------------------------------------------------------------------------
*/
Route::view('/players', 'players.index');
Route::view('/clubs', 'clubs.index');
Route::view('/tournaments', 'tournaments.index');
