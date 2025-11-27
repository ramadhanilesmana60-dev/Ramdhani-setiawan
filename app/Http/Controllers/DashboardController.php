<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Komentar;
use App\Models\Like;
use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'siswa') {
            $artikels = Artikel::where('user_id', $user->id)->get();
            $recentArtikels = Artikel::where('user_id', $user->id)->latest()->take(5)->get();
            $notifikasis = Notifikasi::where('user_id', $user->id)->latest()->take(5)->get();
            return view('dashboard.siswa', compact('artikels', 'recentArtikels', 'notifikasis'));
        } else {
            $totalArtikel = Artikel::count();
            $artikelDraft = Artikel::where('status', 'draft')->count();
            $artikelPublished = Artikel::where('status', 'published')->count();
            $totalSiswa = User::where('role', 'siswa')->count();
            $totalKomentar = Komentar::count();
            $totalLike = Like::count();
            $totalNotifikasi = Notifikasi::count();
            
            return view('dashboard.guru', compact('totalArtikel', 'artikelDraft', 'artikelPublished', 'totalSiswa', 'totalKomentar', 'totalLike', 'totalNotifikasi'));
        }
    }

    public function laporan()
    {
        $artikels = Artikel::with(['user', 'kategori'])
            ->where('status', 'published')
            ->latest()
            ->get();
            
        return view('dashboard.laporan', compact('artikels'));
    }

    public function bacaNotifikasi($id)
    {
        $notifikasi = Notifikasi::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $notifikasi->update(['dibaca' => true]);
        return back();
    }
}