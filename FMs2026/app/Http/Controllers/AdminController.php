<?php

namespace App\Http\Controllers;

use App\Models\GameUser;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Показати дашборд адміна
     */
    public function dashboard()
    {
        $totalUsers = GameUser::count();
        $adminCount = GameUser::where('role', 'admin')->count();
        $playerCount = GameUser::where('role', 'player')->count();
        $recentUsers = GameUser::orderBy('RegisterDate', 'desc')->take(10)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'adminCount',
            'playerCount',
            'recentUsers'
        ));
    }

    /**
     * Показати список всіх користувачів
     */
    public function users(Request $request)
    {
        $query = GameUser::query();

        if ($request->has('role') && $request->role !== '') {
            $query->where('role', $request->role);
        }

        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('Username', 'like', "%{$search}%")
                  ->orWhere('Email', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Показати деталі користувача
     */
    public function showUser($id)
    {
        $user = GameUser::findOrFail($id);
        $userClubs = $user->userClubs()->with(['club', 'season'])->get();

        return view('admin.users.show', compact('user', 'userClubs'));
    }

    /**
     * Змінити роль користувача
     */
    public function changeRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:player,admin',
        ]);

        $user = GameUser::findOrFail($id);
        $user->update(['role' => $request->role]);

        return redirect()->back()->with('success', "Роль користувача '{$user->Username}' змінена на '{$request->role}'");
    }

    /**
     * Видалити користувача
     */
    public function deleteUser($id)
    {
        $user = GameUser::findOrFail($id);
        $username = $user->Username;

        $user->userClubs()->delete();

        $user->delete();

        return redirect()->route('admin.users')->with('success', "Користувач '$username' видалений");
    }

    /**
     * Показати статистику
     */
    public function statistics()
    {
        $stats = [
            'totalUsers' => GameUser::count(),
            'adminCount' => GameUser::where('role', 'admin')->count(),
            'playerCount' => GameUser::where('role', 'player')->count(),
            'usersToday' => GameUser::whereDate('RegisterDate', today())->count(),
            'activeToday' => GameUser::whereDate('LastLogin', today())->count(),
        ];

        return view('admin.statistics', compact('stats'));
    }
}
