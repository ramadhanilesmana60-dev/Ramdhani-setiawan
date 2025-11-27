@extends('layouts.app')

@section('title', 'Kelola Artikel')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-primary">Kelola Artikel</h1>
    <a href="{{ route('artikel.create') }}" class="bg-primary text-white px-4 py-2 rounded hover:bg-secondary">Buat Artikel</a>
</div>

<div class="bg-white rounded-lg shadow-lg overflow-hidden">
    <table class="w-full">
        <thead class="bg-primary text-white">
            <tr>
                <th class="px-6 py-3 text-left">Judul</th>
                <th class="px-6 py-3 text-left">Kategori</th>
                <th class="px-6 py-3 text-left">Penulis</th>
                <th class="px-6 py-3 text-left">Status</th>
                <th class="px-6 py-3 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($artikels as $artikel)
                <tr class="border-b border-gray-200">
                    <td class="px-6 py-4">{{ $artikel->judul }}</td>
                    <td class="px-6 py-4">{{ $artikel->kategori->nama_kategori }}</td>
                    <td class="px-6 py-4">{{ $artikel->user->nama }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded text-xs {{ $artikel->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($artikel->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            @if(auth()->user()->role === 'siswa')
                                @if($artikel->user_id === auth()->id())
                                    <a href="{{ route('artikel.edit', $artikel->id) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                                    <form action="{{ route('artikel.destroy', $artikel->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                                    </form>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            @else
                                <a href="{{ route('artikel.edit', $artikel->id) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                                @if($artikel->status === 'draft')
                                    <form action="{{ route('artikel.approve', $artikel->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-800">Publish</button>
                                    </form>
                                @else
                                    <form action="{{ route('artikel.cancel', $artikel->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-yellow-600 hover:text-yellow-800">Cancel</button>
                                    </form>
                                @endif
                                <form action="{{ route('artikel.destroy', $artikel->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada artikel</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $artikels->links() }}
</div>
@endsection