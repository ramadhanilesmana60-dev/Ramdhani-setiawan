@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-primary">Dashboard Siswa</h1>
    <p class="text-gray-600">Selamat datang, {{ auth()->user()->nama }}!</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-lg font-semibold text-primary mb-2">Total Artikel</h3>
        <p class="text-3xl font-bold text-gray-800">{{ $artikels->count() }}</p>
    </div>
    
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-lg font-semibold text-primary mb-2">Artikel Draft</h3>
        <p class="text-3xl font-bold text-yellow-600">{{ $artikels->where('status', 'draft')->count() }}</p>
    </div>
    
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-lg font-semibold text-primary mb-2">Artikel Published</h3>
        <p class="text-3xl font-bold text-green-600">{{ $artikels->where('status', 'published')->count() }}</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-xl font-bold text-primary mb-4">Menu Utama</h3>
        <div class="space-y-3">
            <a href="{{ route('artikel.create') }}" class="block bg-primary text-white p-3 rounded hover:bg-secondary">
                Buat Artikel Baru
            </a>
            <a href="{{ route('artikel.index') }}" class="block bg-primary text-white p-3 rounded hover:bg-secondary">
                Kelola Artikel Saya
            </a>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-xl font-bold text-primary mb-4">Notifikasi</h3>
        <div class="space-y-2 max-h-48 overflow-y-auto">
            @forelse($notifikasis as $notifikasi)
                <div class="p-3 border rounded {{ $notifikasi->dibaca ? 'bg-gray-50' : 'bg-blue-50 border-blue-200' }}">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <h4 class="font-semibold text-sm">{{ $notifikasi->judul }}</h4>
                            <p class="text-xs text-gray-600 mt-1">{{ $notifikasi->pesan }}</p>
                            <span class="text-xs text-gray-400">{{ $notifikasi->created_at->diffForHumans() }}</span>
                        </div>
                        @if(!$notifikasi->dibaca)
                            <form action="{{ route('notifikasi.baca', $notifikasi->id) }}" method="POST" class="ml-2">
                                @csrf
                                <button type="submit" class="text-xs text-blue-600 hover:text-blue-800">Tandai Dibaca</button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-sm">Tidak ada notifikasi</p>
            @endforelse
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-xl font-bold text-primary mb-4">Tips untuk Siswa</h3>
        <div class="space-y-2 text-gray-600">
            <p>• Tulis artikel dengan judul yang menarik</p>
            <p>• Gunakan foto yang relevan dengan artikel</p>
            <p>• Artikel akan di-review guru sebelum dipublikasi</p>
            <p>• Anda hanya bisa mengedit artikel milik sendiri</p>
            <p>• Berikan komentar positif pada artikel teman</p>
        </div>
    </div>
</div>

<div class="flex justify-between items-center mb-4">
    <h2 class="text-xl font-bold text-primary">Artikel Terbaru Saya</h2>
    <a href="{{ route('artikel.index') }}" class="text-primary hover:text-secondary">Lihat Semua</a>
</div>

<div class="bg-white rounded-lg shadow-lg overflow-hidden">
    <table class="w-full">
        <thead class="bg-primary text-white">
            <tr>
                <th class="px-6 py-3 text-left">Judul</th>
                <th class="px-6 py-3 text-left">Status</th>
                <th class="px-6 py-3 text-left">Tanggal</th>
                <th class="px-6 py-3 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentArtikels as $artikel)
                <tr class="border-b border-gray-200">
                    <td class="px-6 py-4">{{ $artikel->judul }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded text-xs {{ $artikel->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($artikel->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">{{ $artikel->tanggal }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('artikel.edit', $artikel->id) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                        Belum ada artikel. <a href="{{ route('artikel.create') }}" class="text-primary hover:text-secondary">Buat artikel pertama</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection