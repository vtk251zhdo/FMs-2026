<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserClub;
use App\Models\Transfer;
use App\Models\Player;

class TransferController extends Controller
{
    /**
     * Show transfer market
     */
    public function market()
    {
        $userClub = UserClub::with('club')->first();
        
        if (!$userClub) {
            return redirect()->route('dashboard');
        }

        // Get players from other clubs (market)
        $availablePlayers = Player::where('ClubID', '!=', $userClub->ClubID)
            ->orderBy('Rating', 'desc')
            ->paginate(15);

        return view('transfers.market', [
            'players' => $availablePlayers,
            'club' => $userClub->club,
        ]);
    }

    /**
     * Show club's players for sale
     */
    public function sellPlayers()
    {
        $userClub = UserClub::with('club')->first();
        
        if (!$userClub) {
            return redirect()->route('dashboard');
        }

        $players = $userClub->club->players()->get();

        return view('transfers.sell', [
            'players' => $players,
            'club' => $userClub->club,
        ]);
    }

    /**
     * Make an offer for a player
     */
    public function makeOffer(Request $request, $playerId)
    {
        $validated = $request->validate([
            'offer_amount' => 'required|numeric|min:0',
        ]);

        $userClub = UserClub::with('club')->first();
        
        if (!$userClub) {
            return redirect()->route('dashboard');
        }

        $player = Player::findOrFail($playerId);

        // Check budget
        if ($userClub->club->Budget < $validated['offer_amount']) {
            return back()->with('error', 'Недостатньо коштів!');
        }

        // Create transfer record
        Transfer::create([
            'PlayerID' => $playerId,
            'FromClubID' => $player->ClubID,
            'ToClubID' => $userClub->club->ClubID,
            'TransferFee' => $validated['offer_amount'],
            'TransferDate' => now()->toDateString(),
        ]);

        // Update player's club
        $player->update(['ClubID' => $userClub->club->ClubID]);

        // Deduct from budget
        $userClub->club->decrement('Budget', $validated['offer_amount']);

        // Add to selling club budget
        $oldClub = $player->club;
        if ($oldClub) {
            $oldClub->increment('Budget', (int)($validated['offer_amount'] * 0.9));
        }

        return redirect()->route('transfers.market')->with('success', 'Гравець куплений!');
    }

    /**
     * Sell player
     */
    public function sellPlayer(Request $request, $playerId)
    {
        $validated = $request->validate([
            'sell_price' => 'required|numeric|min:0',
        ]);

        $userClub = UserClub::with('club')->first();
        
        if (!$userClub) {
            return redirect()->route('dashboard');
        }

        $player = Player::where('ClubID', $userClub->club->ClubID)->findOrFail($playerId);

        // Create transfer record (sold)
        Transfer::create([
            'PlayerID' => $playerId,
            'FromClubID' => $userClub->club->ClubID,
            'ToClubID' => null,
            'TransferFee' => $validated['sell_price'],
            'TransferDate' => now()->toDateString(),
        ]);

        // Remove player from club
        $player->delete();

        // Add to budget
        $userClub->club->increment('Budget', $validated['sell_price']);

        return back()->with('success', 'Гравець продадий!');
    }

    /**
     * Show transfer history
     */
    public function history()
    {
        $userClub = UserClub::with('club')->first();

        if (!$userClub) {
            return redirect()->route('dashboard');
        }

        $transfers = Transfer::where('FromClubID', $userClub->club->ClubID)
            ->orWhere('ToClubID', $userClub->club->ClubID)
            ->orderBy('TransferDate', 'desc')
            ->paginate(20);

        return view('transfers.history', [
            'transfers' => $transfers,
        ]);
    }
}
