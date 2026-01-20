<?php

namespace App\Http\Controllers;

use App\Models\GameUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $user = GameUser::create([
            'Username' => $request->username,
            'Email' => $request->email,
            'PasswordHash' => Hash::make($request->password),
            'RegisterDate' => now()->toDateString(),
            'LastLogin' => now(),
            'role' => 'player', 
        ]);

        Session::put('user_id', $user->UserID);
        Session::put('username', $user->Username);
        Session::put('role', $user->role);

        return redirect('/dashboard');
    }

    public function login(Request $request)
    {
        $user = GameUser::where('Username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->PasswordHash)) {
            return back()->with('error', 'Невірний логін або пароль');
        }

        $user->update(['LastLogin' => now()]);
        Session::put('user_id', $user->UserID);
        Session::put('username', $user->Username);
        Session::put('role', $user->role);

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect('/dashboard');
    }

    public function logout()
    {
        Session::forget(['user_id', 'username']);
        return redirect('/');
    }
}