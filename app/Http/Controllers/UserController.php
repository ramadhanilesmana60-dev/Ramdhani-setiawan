<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', '!=', 'admin')->latest()->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:255',
            'username' => 'required|unique:users|max:255',
            'password' => 'required|min:6',
            'role' => 'required|in:guru,siswa'
        ]);

        User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'approved' => true
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->update(['approved' => true]);
        
        Notifikasi::create([
            'user_id' => $user->id,
            'judul' => 'Akun Disetujui',
            'pesan' => 'Akun Anda telah disetujui admin. Sekarang Anda dapat login.'
        ]);
        
        return back()->with('success', 'User berhasil disetujui');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->role === 'admin') {
            return back()->with('error', 'Admin tidak dapat dihapus');
        }
        
        // Hapus semua data terkait user
        $user->artikels()->delete();
        $user->komentars()->delete();
        $user->likes()->delete();
        $user->notifikasis()->delete();
        
        // Hapus user
        $user->delete();
        
        return back()->with('success', 'User berhasil dihapus');
    }

    public function profile()
    {
        $user = auth()->user();
        $artikels = $user->artikels()->latest()->get();
        return view('users.profile', compact('user', 'artikels'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:255',
            'username' => 'required|unique:users,username,' . auth()->id() . '|max:255',
            'password' => 'nullable|min:6',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $user = auth()->user();
        $data = [
            'nama' => $request->nama,
            'username' => $request->username
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto && file_exists(storage_path('app/public/' . $user->foto))) {
                unlink(storage_path('app/public/' . $user->foto));
            }
            
            $foto = $request->file('foto');
            $filename = time() . '_' . $foto->getClientOriginalName();
            $path = $foto->storeAs('profile', $filename, 'public');
            $data['foto'] = $path;
        }

        $user->update($data);
        return back()->with('success', 'Profile berhasil diperbarui');
    }
}
