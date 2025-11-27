<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Kategori;
use App\Models\Like;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Artikel::with(['user', 'kategori', 'likes', 'komentars'])
            ->where('status', 'published');
        
        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }
        
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }
        
        $artikels = $query->latest()->get();
        
        // Add user like status for each article
        foreach ($artikels as $artikel) {
            if (auth()->check()) {
                $artikel->user_liked = $artikel->likes->where('user_id', auth()->id())->isNotEmpty();
            } else {
                $artikel->user_liked = $artikel->likes->where('ip_address', $request->ip())->whereNull('user_id')->isNotEmpty();
            }
        }
        
        $kategoris = Kategori::all();
        
        $artikelPopuler = Artikel::with(['user', 'kategori', 'likes', 'komentars'])
            ->where('status', 'published')
            ->latest()
            ->take(3)
            ->get();
        
        // Add user like status for popular articles
        foreach ($artikelPopuler as $artikel) {
            if (auth()->check()) {
                $artikel->user_liked = $artikel->likes->where('user_id', auth()->id())->isNotEmpty();
            } else {
                $artikel->user_liked = $artikel->likes->where('ip_address', $request->ip())->whereNull('user_id')->isNotEmpty();
            }
        }
        
        return view('home', compact('artikels', 'kategoris', 'artikelPopuler'));
    }

    public function show($id)
    {
        $artikel = Artikel::with(['user', 'kategori', 'komentars.user', 'likes'])
            ->where('status', 'published')
            ->findOrFail($id);
        
        return view('artikel.show', compact('artikel'));
    }

    public function publicLike(Request $request, $id)
    {
        $artikel = Artikel::findOrFail($id);
        $ipAddress = $request->ip();
        $like = Like::where('artikel_id', $id)
            ->where('ip_address', $ipAddress)
            ->whereNull('user_id')
            ->first();
        
        if ($like) {
            $like->delete();
        } else {
            Like::create([
                'artikel_id' => $id,
                'ip_address' => $ipAddress
            ]);
            
            // Buat notifikasi untuk penulis artikel dari pengunjung publik
            \App\Models\Notifikasi::create([
                'user_id' => $artikel->user_id,
                'judul' => 'Like Baru dari Pengunjung',
                'pesan' => 'Seseorang menyukai artikel "' . $artikel->judul . '"'
            ]);
        }

        return back();
    }
}