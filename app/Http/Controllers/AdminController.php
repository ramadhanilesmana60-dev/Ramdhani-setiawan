<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use App\Models\Like;
use App\Models\Notifikasi;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function komentars()
    {
        $komentars = Komentar::with(['user', 'artikel'])->latest()->paginate(15);
        return view('admin.komentars', compact('komentars'));
    }

    public function likes()
    {
        $likes = Like::with(['user', 'artikel'])->latest()->paginate(15);
        return view('admin.likes', compact('likes'));
    }

    public function deleteKomentar($id)
    {
        $komentar = Komentar::findOrFail($id);
        
        // Buat notifikasi untuk user yang komentarnya dihapus (jika user masih ada)
        if ($komentar->user_id && $komentar->user && $komentar->artikel) {
            Notifikasi::create([
                'user_id' => $komentar->user_id,
                'judul' => 'Komentar Dihapus',
                'pesan' => 'Komentar Anda pada artikel "' . $komentar->artikel->judul . '" telah dihapus oleh admin.'
            ]);
        }
        
        $komentar->delete();
        return back()->with('success', 'Komentar berhasil dihapus');
    }

    public function deleteLike($id)
    {
        $like = Like::findOrFail($id);
        
        // Buat notifikasi untuk user yang likenya dihapus (jika user masih ada)
        if ($like->user_id && $like->user && $like->artikel) {
            Notifikasi::create([
                'user_id' => $like->user_id,
                'judul' => 'Like Dihapus',
                'pesan' => 'Like Anda pada artikel "' . $like->artikel->judul . '" telah dihapus oleh admin.'
            ]);
        }
        
        $like->delete();
        return back()->with('success', 'Like berhasil dihapus');
    }

    public function notifikasis()
    {
        $notifikasis = Notifikasi::with('user')->latest()->paginate(15);
        return view('admin.notifikasis', compact('notifikasis'));
    }

    public function deleteNotifikasi($id)
    {
        $notifikasi = Notifikasi::findOrFail($id);
        $notifikasi->delete();
        return back()->with('success', 'Notifikasi berhasil dihapus');
    }
}