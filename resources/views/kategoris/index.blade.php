@extends('layouts.app')

@section('title', 'Kelola Kategori')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-primary">Kelola Kategori</h1>
    <a href="{{ route('kategoris.create') }}" class="bg-primary text-white px-4 py-2 rounded hover:bg-secondary">
        Tambah Kategori
    </a>
</div>

<div class="bg-white rounded-lg shadow-lg overflow-hidden">
    <table class="w-full">
        <thead class="bg-primary text-white">
            <tr>
                <th class="px-6 py-3 text-left">Nama Kategori</th>
                <th class="px-6 py-3 text-left">Jumlah Artikel</th>
                <th class="px-6 py-3 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kategoris as $kategori)
                <tr class="border-b border-gray-200">
                    <td class="px-6 py-4">{{ $kategori->nama_kategori }}</td>
                    <td class="px-6 py-4">{{ $kategori->artikels_count }}</td>
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            <a href="{{ route('kategoris.edit', $kategori->id) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                            <form action="{{ route('kategoris.destroy', $kategori->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">Belum ada kategori</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection