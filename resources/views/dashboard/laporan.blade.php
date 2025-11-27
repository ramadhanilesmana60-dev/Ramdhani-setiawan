@extends('layouts.app')

@section('title', 'Laporan Artikel')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-primary">Laporan Artikel Published</h1>
    <button onclick="window.print()" class="bg-primary text-white px-4 py-2 rounded hover:bg-secondary">
        Cetak Laporan
    </button>
</div>

<div class="bg-white rounded-lg shadow-lg p-6">
    <div class="mb-4">
        <h2 class="text-lg font-semibold">Total Artikel Published: {{ $artikels->count() }}</h2>
        <p class="text-gray-600">Laporan dibuat pada: {{ now()->format('d/m/Y H:i') }}</p>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-primary text-white">
                <tr>
                    <th class="px-4 py-3 text-left">No</th>
                    <th class="px-4 py-3 text-left">Judul</th>
                    <th class="px-4 py-3 text-left">Penulis</th>
                    <th class="px-4 py-3 text-left">Kategori</th>
                    <th class="px-4 py-3 text-left">Tanggal</th>
                    <th class="px-4 py-3 text-left">Likes</th>
                    <th class="px-4 py-3 text-left">Komentar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($artikels as $index => $artikel)
                    <tr class="border-b border-gray-200">
                        <td class="px-4 py-3">{{ $index + 1 }}</td>
                        <td class="px-4 py-3">{{ $artikel->judul }}</td>
                        <td class="px-4 py-3">{{ $artikel->user->nama }}</td>
                        <td class="px-4 py-3">{{ $artikel->kategori->nama_kategori }}</td>
                        <td class="px-4 py-3">{{ $artikel->tanggal }}</td>
                        <td class="px-4 py-3">{{ $artikel->likes->count() }}</td>
                        <td class="px-4 py-3">{{ $artikel->komentars->count() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-3 text-center text-gray-500">Belum ada artikel yang dipublikasikan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
@media print {
    .no-print { display: none !important; }
    body { background: white !important; }
}
</style>
@endsection