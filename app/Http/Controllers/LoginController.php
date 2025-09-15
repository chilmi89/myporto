<?php

namespace App\Http\Controllers;

use App\Models\RoleRedirect;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


class LoginController extends Controller
{
    public function index()
    {
        return view('Auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required']
        ]);

        // Coba login
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Ambil role pertama user
            $role = $user->getRoleNames()->first();

            if ($role) {
                // Cari mapping di tabel role_redirects
                $redirect = RoleRedirect::where('role_name', $role)->first();

                if ($redirect && Route::has($redirect->route_name)) {
                    return redirect()->route($redirect->route_name);
                }

                // Kalau tidak ada mapping atau route tidak ditemukan
                abort(404, 'Halaman untuk role ini tidak ditemukan.');
            }

            // Kalau user tidak punya role sama sekali
            abort(403, 'Anda tidak memiliki akses ke halaman manapun.');
        }

        // Jika gagal
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda sudah logout.');
    }
}
