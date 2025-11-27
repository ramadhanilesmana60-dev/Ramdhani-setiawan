@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-primary">{{ auth()->user()->role === 'admin' ? 'Dashboard Admin' : 'Dashboard Guru' }}</h1>
    <p class="text-gray-600">Selamat datang, {{ auth()->user()->nama }}!</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-lg font-semibold text-primary mb-2">Total Artikel</h3>
        <p class="text-3xl font-bold text-gray-800">{{ $totalArtikel }}</p>
    </div>
    
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-lg font-semibold text-primary mb-2">Artikel Draft</h3>
        <p class="text-3xl font-bold text-yellow-600">{{ $artikelDraft }}</p>
    </div>
    
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-lg font-semibold text-primary mb-2">Artikel Published</h3>
        <p class="text-3xl font-bold text-green-600">{{ $artikelPublished }}</p>
    </div>
    
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-lg font-semibold text-primary mb-2">Total Siswa</h3>
        <p class="text-3xl font-bold text-gray-800">{{ $totalSiswa }}</p>
    </div>
</div>

@if(auth()->user()->role === 'admin')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-lg font-semibold text-blue-600 mb-2">Total Komentar</h3>
        <p class="text-3xl font-bold text-blue-800">{{ $totalKomentar }}</p>
    </div>
    
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-lg font-semibold text-red-600 mb-2">Total Like</h3>
        <p class="text-3xl font-bold text-red-800">{{ $totalLike }}</p>
    </div>
    
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-lg font-semibold text-green-600 mb-2">Total Notifikasi</h3>
        <p class="text-3xl font-bold text-green-800">{{ $totalNotifikasi }}</p>
    </div>
</div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-xl font-bold text-primary mb-4">Menu Utama</h3>
        <div class="space-y-3">
            <a href="{{ route('artikel.index') }}" class="block bg-primary text-white p-3 rounded hover:bg-secondary">
                Kelola Artikel
            </a>
            @if(auth()->user()->role === 'guru')
                <a href="{{ route('artikel.create') }}" class="block bg-primary text-white p-3 rounded hover:bg-secondary">
                    Buat Artikel Baru
                </a>
            @endif
            <a href="{{ route('laporan') }}" class="block bg-primary text-white p-3 rounded hover:bg-secondary">
                Laporan Artikel
            </a>
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('users.index') }}" class="block bg-primary text-white p-3 rounded hover:bg-secondary">
                    Manajemen User
                </a>
                <a href="{{ route('kategoris.index') }}" class="block bg-primary text-white p-3 rounded hover:bg-secondary">
                    Kelola Kategori
                </a>
                <a href="{{ route('admin.komentars') }}" class="block bg-primary text-white p-3 rounded hover:bg-secondary">
                    Kelola Komentar
                </a>
                <a href="{{ route('admin.likes') }}" class="block bg-primary text-white p-3 rounded hover:bg-secondary">
                    Kelola Like
                </a>
                <a href="{{ route('admin.notifikasis') }}" class="block bg-primary text-white p-3 rounded hover:bg-secondary">
                    Kelola Notifikasi
                </a>
            @endif
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-xl font-bold text-primary mb-4">Informasi</h3>
        <div class="space-y-2 text-gray-600">
            <p>• Verifikasi artikel siswa sebelum dipublikasikan</p>
            <p>• Pantau aktivitas siswa dalam menulis artikel</p>
            <p>• Generate laporan artikel yang telah dipublikasikan</p>
            <p>• Kelola konten e-mading sekolah</p>
        </div>
    </div>
</div>
@endsection