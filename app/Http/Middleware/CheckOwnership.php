<?php

namespace App\Http\Middleware;

use App\Models\Artikel;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckOwnership
{
    public function handle(Request $request, Closure $next)
    {
        $artikelId = $request->route('artikel');
        
        if ($artikelId && is_numeric($artikelId)) {
            $artikel = Artikel::findOrFail($artikelId);
            
            if (Auth::user()->role === 'siswa' && $artikel->user_id !== Auth::id()) {
                abort(403, 'Anda hanya dapat mengedit artikel milik sendiri');
            }
        }
        
        return $next($request);
    }
}