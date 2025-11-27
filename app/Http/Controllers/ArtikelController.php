<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Kategori;
use App\Models\Komentar;
use App\Models\Like;
use App\Models\Notifikasi;
use App\Helpers\ContentFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArtikelController extends Controller
{
    public function index()
    {
        $query = Artikel::with(['user', 'kategori']);
        
        if (Auth::user()->role === 'siswa') {
            $query->where('user_id', Auth::id());
        }
        
        $artikels = $query->latest()->paginate(10);
        return view('artikel.index', compact('artikels'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('artikel.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'isi' => 'required',
            'kategori_id' => 'required|exists:kategoris,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $data = [
            'judul' => ContentFilter::filterContent($request->judul),
            'isi' => ContentFilter::filterContent($request->isi),
            'kategori_id' => $request->kategori_id,
            'user_id' => Auth::id(),
            'tanggal' => now()->toDateString(),
        ];
        
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            if ($file->isValid()) {
                $data['foto'] = $file->store('artikel', 'public');
            }
        }

        Artikel::create($data);
        return redirect()->route('artikel.index')->with('success', 'Artikel berhasil dibuat');
    }

    public function edit($id)
    {
        $artikel = Artikel::findOrFail($id);
        
        if (Auth::user()->role === 'siswa' && $artikel->user_id !== Auth::id()) {
            abort(403);
        }
        
        $kategoris = Kategori::all();
        return view('artikel.edit', compact('artikel', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $artikel = Artikel::findOrFail($id);
        
        if (Auth::user()->role === 'siswa' && $artikel->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'judul' => 'required|max:255',
            'isi' => 'required',
            'kategori_id' => 'required|exists:kategoris,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp'
        ]);

        $data = $request->all();
        $data['judul'] = ContentFilter::filterContent($request->judul);
        $data['isi'] = ContentFilter::filterContent($request->isi);
        
        if ($request->hasFile('foto')) {
            if ($artikel->foto) {
                Storage::disk('public')->delete($artikel->foto);
            }
            $data['foto'] = $request->file('foto')->store('artikel', 'public');
        }

        $artikel->update($data);
        return redirect()->route('artikel.index')->with('success', 'Artikel berhasil diupdate');
    }

    public function approve($id)
    {
        $artikel = Artikel::findOrFail($id);
        $artikel->update(['status' => 'published']);
        
        Notifikasi::create([
            'user_id' => $artikel->user_id,
            'judul' => 'Artikel Disetujui',
            'pesan' => 'Artikel "' . $artikel->judul . '" telah disetujui dan dipublikasikan.'
        ]);
        
        return back()->with('success', 'Artikel berhasil dipublish');
    }

    public function cancel($id)
    {
        $artikel = Artikel::findOrFail($id);
        $artikel->update(['status' => 'draft']);
        
        Notifikasi::create([
            'user_id' => $artikel->user_id,
            'judul' => 'Artikel Dibatalkan',
            'pesan' => 'Artikel "' . $artikel->judul . '" telah dibatalkan publikasinya.'
        ]);
        
        return back()->with('success', 'Artikel berhasil dibatalkan');
    }

    public function comment(Request $request, $id)
    {
        $request->validate(['isi' => 'required']);
        
        $artikel = Artikel::findOrFail($id);
        
        Komentar::create([
            'artikel_id' => $id,
            'user_id' => Auth::id(),
            'isi' => ContentFilter::filterContent($request->isi)
        ]);

        // Buat notifikasi untuk penulis artikel (jika bukan diri sendiri)
        if ($artikel->user_id !== Auth::id()) {
            Notifikasi::create([
                'user_id' => $artikel->user_id,
                'judul' => 'Komentar Baru',
                'pesan' => Auth::user()->nama . ' (' . Auth::user()->role . ') mengomentari artikel "' . $artikel->judul . '"'
            ]);
        }

        return back()->with('success', 'Komentar berhasil ditambahkan');
    }

    public function like($id)
    {
        $artikel = Artikel::findOrFail($id);
        $like = Like::where('artikel_id', $id)->where('user_id', Auth::id())->first();
        
        if ($like) {
            $like->delete();
        } else {
            Like::create(['artikel_id' => $id, 'user_id' => Auth::id()]);
            
            // Buat notifikasi untuk penulis artikel (jika bukan diri sendiri)
            if ($artikel->user_id !== Auth::id()) {
                Notifikasi::create([
                    'user_id' => $artikel->user_id,
                    'judul' => 'Like Baru',
                    'pesan' => Auth::user()->nama . ' (' . Auth::user()->role . ') menyukai artikel "' . $artikel->judul . '"'
                ]);
            }
        }

        return back();
    }

    public function destroy($id)
    {
        $artikel = Artikel::findOrFail($id);
        
        // Validasi hak akses: admin dan guru bisa hapus semua, siswa hanya miliknya
        if (Auth::user()->role === 'siswa' && $artikel->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus artikel ini');
        }
        
        // Hapus komentar terkait
        $artikel->komentars()->delete();
        
        // Hapus likes terkait
        $artikel->likes()->delete();
        
        // Hapus foto jika ada
        if ($artikel->foto) {
            Storage::disk('public')->delete($artikel->foto);
        }
        
        // Hapus artikel
        $artikel->delete();
        
        return redirect()->route('artikel.index')->with('success', 'Artikel berhasil dihapus');
    }

    public function deleteComment($id)
    {
        $komentar = Komentar::findOrFail($id);
        
        // Admin dan guru bisa hapus semua komentar, siswa hanya miliknya
        if (Auth::user()->role === 'siswa' && $komentar->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus komentar ini');
        }
        
        $komentar->delete();
        return back()->with('success', 'Komentar berhasil dihapus');
    }
}