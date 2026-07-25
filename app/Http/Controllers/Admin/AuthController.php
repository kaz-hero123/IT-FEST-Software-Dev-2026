<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Tampilkan form login admin.
     * URL: GET /admin/login
     */
    public function loginForm()
    {
        return view('pages.admin.auth.login');
    }

    /**
     * Proses login admin.
     * URL: POST /admin/login
     */
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->validated())) {
            return back()
                ->withErrors(['email' => 'Email atau password salah.'])
                ->withInput();
        }

        // Cek apakah user yang login punya role admin
        if (Auth::user()->role !== 'admin') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->with('error', 'Akses ditolak. Halaman ini hanya untuk admin.')
                ->withInput();
        }

        $request->session()->regenerate();

        return redirect('/admin/dashboard');
    }

    /**
     * Logout admin.
     * URL: POST /admin/logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
