@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-primary mb-6">Edit Kategori</h1>
    
    <div class="bg-white rounded-lg shadow-lg p-6">
        <form action="{{ route('kategoris.update', $kategori->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Kategori</label>
                <input type="text" name="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-primary" required>
                @error('nama_kategori')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex justify-between">
                <a href="{{ route('kategoris.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</a>
                <button type="submit" class="bg-primary text-white px-4 py-2 rounded hover:bg-secondary">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection