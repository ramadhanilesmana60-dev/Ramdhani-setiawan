@extends('layouts.app')

@section('title', $artikel->judul . ' - E-Mading')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('home') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali
        </a>
    </div>
    <article class="bg-white rounded-lg shadow-lg overflow-hidden">
        @if($artikel->foto)
            <div class="w-full max-h-96 overflow-hidden flex items-center justify-center bg-gray-50">
                <img src="{{ asset('storage/' . $artikel->foto) }}" alt="{{ $artikel->judul }}" class="max-w-full max-h-96 object-contain">
            </div>
        @endif
        
        <div class="p-8">
            <div class="flex items-center justify-between mb-4">
                <span class="bg-primary text-white px-3 py-1 rounded">{{ $artikel->kategori->nama_kategori }}</span>
                <div class="text-gray-500 text-right">
                    <div>{{ $artikel->tanggal }}</div>
                    <div class="text-sm">{{ $artikel->created_at->format('H:i') }} WIB</div>
                </div>
            </div>
            
            <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $artikel->judul }}</h1>
            
            <div class="flex items-center mb-6">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full overflow-hidden">
                        @if($artikel->user->foto)
                            <img src="{{ asset('storage/' . $artikel->user->foto) }}" alt="{{ $artikel->user->nama }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-blue-100 flex items-center justify-center">
                                <span class="text-blue-600 font-semibold text-sm">{{ substr($artikel->user->nama, 0, 1) }}</span>
                            </div>
                        @endif
                    </div>
                    <span class="text-gray-600">Oleh: {{ $artikel->user->nama }}</span>
                </div>
                @auth
                    <form action="{{ route('artikel.like', $artikel->id) }}" method="POST" class="ml-4">
                        @csrf
                        <button type="submit" class="flex items-center space-x-1 text-primary hover:text-secondary">
                            <span>♥</span>
                            <span>{{ $artikel->likes->count() }}</span>
                        </button>
                    </form>
                @else
                    <form action="{{ route('artikel.public-like', $artikel->id) }}" method="POST" class="ml-4">
                        @csrf
                        <button type="submit" class="flex items-center space-x-1 text-primary hover:text-secondary">
                            <span>♥</span>
                            <span>{{ $artikel->likes->count() }}</span>
                        </button>
                    </form>
                @endauth
            </div>
            
            <div class="prose max-w-none text-gray-700 leading-relaxed">
                {!! nl2br(e($artikel->isi)) !!}
            </div>
        </div>
    </article>
    
    @auth
        <div class="mt-8 bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-xl font-bold mb-4">Tambah Komentar</h3>
            <form action="{{ route('artikel.comment', $artikel->id) }}" method="POST">
                @csrf
                <textarea name="isi" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-primary" placeholder="Tulis komentar..." required></textarea>
                <button type="submit" class="mt-2 bg-primary text-white px-4 py-2 rounded hover:bg-secondary">Kirim</button>
            </form>
        </div>
    @endauth
    
    <div class="mt-8 bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-xl font-bold mb-4">Komentar ({{ $artikel->komentars->count() }})</h3>
        @forelse($artikel->komentars as $komentar)
            <div class="border-b border-gray-200 pb-4 mb-4 last:border-b-0">
                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 rounded-full overflow-hidden flex-shrink-0">
                        @if($komentar->user && $komentar->user->foto)
                            <img src="{{ asset('storage/' . $komentar->user->foto) }}" alt="{{ $komentar->user->nama }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-blue-100 flex items-center justify-center">
                                <span class="text-blue-600 font-semibold text-xs">{{ $komentar->user ? substr($komentar->user->nama, 0, 1) : '?' }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-semibold text-gray-800">{{ $komentar->user ? $komentar->user->nama : 'User Dihapus' }}</span>
                            <div class="flex items-center space-x-2">
                                <span class="text-gray-500 text-sm">{{ $komentar->created_at->diffForHumans() }}</span>
                                @auth
                                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'guru' || $komentar->user_id === auth()->id())
                                        <form action="{{ route('komentar.delete', $komentar->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus komentar ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </div>
                        <p class="text-gray-700">{{ $komentar->isi }}</p>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-gray-500">Belum ada komentar</p>
        @endforelse
    </div>
</div>
@endsection