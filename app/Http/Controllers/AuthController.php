<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('username', $request->username)->first();
        
        if ($user && Hash::check($request->password, $user->password)) {
            if (!$user->approved) {
                return back()->withErrors(['username' => 'Akun Anda belum disetujui admin']);
            }
            
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['username' => 'Username atau password salah']);
    }

    public function register()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:255',
            'username' => 'required|unique:users|max:255',
            'password' => 'required|min:6|confirmed'
        ]);

        User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'siswa',
            'approved' => false
        ]);

        // Notify admin
        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            Notifikasi::create([
                'user_id' => $admin->id,
                'judul' => 'Pendaftaran Baru',
                'pesan' => 'User baru "' . $request->nama . '" mendaftar dan menunggu persetujuan.'
            ]);
        }

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat, menunggu persetujuan admin');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}