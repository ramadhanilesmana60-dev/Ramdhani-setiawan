@extends('layouts.app')

@section('title', 'Edit Artikel')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold text-primary mb-6">Edit Artikel</h1>
    
    <div class="bg-white rounded-lg shadow-lg p-6">
        <form action="{{ route('artikel.update', $artikel->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Judul</label>
                <input type="text" name="judul" value="{{ old('judul', $artikel->judul) }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-primary" required>
                @error('judul')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Kategori</label>
                <select name="kategori_id" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-primary" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ old('kategori_id', $artikel->kategori_id) == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
                @error('kategori_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Foto</label>
                @if($artikel->foto)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $artikel->foto) }}" alt="Current" class="max-w-full h-auto max-h-64 object-contain rounded border">
                        <p class="text-sm text-gray-500 mt-1">Foto saat ini</p>
                    </div>
                @endif
                <input type="file" name="foto" accept="image/*" id="foto-input-edit"
                       class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-primary">
                <div id="foto-preview-edit" class="mt-3 hidden">
                    <img id="preview-img-edit" src="" alt="Preview" class="max-w-full h-auto max-h-64 object-contain rounded border">
                    <p class="text-sm text-gray-500 mt-1">Preview foto baru</p>
                </div>
                @error('foto')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Isi Artikel</label>
                <textarea name="isi" rows="10" 
                          class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-primary" required>{{ old('isi', $artikel->isi) }}</textarea>
                @error('isi')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex justify-between">
                <a href="{{ route('artikel.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</a>
                <button type="submit" class="bg-primary text-white px-4 py-2 rounded hover:bg-secondary">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('foto-input-edit').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('foto-preview-edit');
    const previewImg = document.getElementById('preview-img-edit');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    } else {
        preview.classList.add('hidden');
    }
});
</script>
@endsection