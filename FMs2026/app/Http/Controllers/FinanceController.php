<?php

namespace App\Http\Controllers;

use App\Models\UserClub;
use App\Models\Transfer;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index()
    {
        $userClub = UserClub::with(['club', 'season'])->first();
        
        if (!$userClub) {
            return redirect()->route('dashboard');
        }

        $club = $userClub->club;
        $season = $userClub->season;
        
        $currentBudget = $club->Budget;
        $squadValue = $club->players()->sum('Value');
        
        $recentTransfers = Transfer::where('ToClubID', $club->ClubID)
            ->orWhere('FromClubID', $club->ClubID)
            ->orderBy('TransferDate', 'desc')
            ->limit(10)
            ->get();
        
        $transferSpending = Transfer::where('ToClubID', $club->ClubID)
            ->whereYear('TransferDate', $season->StartDate->year)
            ->sum('TransferFee');
        
        $transferIncome = Transfer::where('FromClubID', $club->ClubID)
            ->whereYear('TransferDate', $season->StartDate->year)
            ->sum('TransferFee');

        return view('finances.index', [
            'club' => $club,
            'currentBudget' => $currentBudget,
            'squadValue' => $squadValue,
            'recentTransfers' => $recentTransfers,
            'transferSpending' => $transferSpending,
            'transferIncome' => $transferIncome,
            'netSpending' => $transferSpending - $transferIncome,
        ]);
    }

    public function budget()
    {
        $userClub = UserClub::with(['club', 'season'])->first();
        
        if (!$userClub) {
            return redirect()->route('dashboard');
        }

        $club = $userClub->club;
        $season = $userClub->season;
        
        $squadValue = $club->players()->sum('Value');
        $recentTransfers = Transfer::where('ToClubID', $club->ClubID)
            ->orWhere('FromClubID', $club->ClubID)
            ->orderBy('TransferDate', 'desc')
            ->limit(10)
            ->get();
        
        $transferSpending = Transfer::where('ToClubID', $club->ClubID)
            ->whereYear('TransferDate', $season->StartDate->year)
            ->sum('TransferFee');
        
        $transferIncome = Transfer::where('FromClubID', $club->ClubID)
            ->whereYear('TransferDate', $season->StartDate->year)
            ->sum('TransferFee');

        return view('finances.budget', [
            'club' => $club,
            'squadValue' => $squadValue,
            'recentTransfers' => $recentTransfers,
            'transferSpending' => $transferSpending,
            'transferIncome' => $transferIncome,
        ]);
    }
}
