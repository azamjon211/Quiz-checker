<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials) && Auth::user()->isAdmin()) {
            $request->session()->regenerate();

            Log::info('Admin login', [
                'email' => $request->email,
                'ip'    => $request->ip(),
            ]);

            return redirect()->route('admin.dashboard');
        }

        Auth::logout();

        Log::warning('Failed admin login attempt', [
            'email' => $request->email,
            'ip'    => $request->ip(),
        ]);

        return back()
            ->withErrors(['email' => 'Email yoki parol noto\'g\'ri.'])
            ->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Log::info('Admin logout', ['ip' => $request->ip()]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
