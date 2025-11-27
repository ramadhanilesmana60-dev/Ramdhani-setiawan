@extends('layouts.app')

@section('title', 'Buat Artikel')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold text-primary mb-6">Buat Artikel Baru</h1>
    
    <div class="bg-white rounded-lg shadow-lg p-6">
        <form action="{{ route('artikel.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Judul</label>
                <input type="text" name="judul" value="{{ old('judul') }}" 
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
                        <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
                @error('kategori_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Foto (Opsional)</label>
                <input type="file" name="foto" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" id="foto-input"
                       class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-primary">
                <small class="text-gray-500">Format: JPEG, PNG, JPG, GIF, WEBP. Maksimal 2MB</small>
                <div id="foto-preview" class="mt-3 hidden">
                    <img id="preview-img" src="" alt="Preview" class="max-w-full h-auto max-h-64 object-contain rounded border">
                </div>
                @error('foto')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Isi Artikel</label>
                <textarea name="isi" rows="10" 
                          class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-primary" required>{{ old('isi') }}</textarea>
                @error('isi')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex justify-between">
                <a href="{{ route('artikel.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</a>
                <button type="submit" class="bg-primary text-white px-4 py-2 rounded hover:bg-secondary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('foto-input').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('foto-preview');
    const previewImg = document.getElementById('preview-img');
    
    if (file) {
        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
        if (!allowedTypes.includes(file.type)) {
            alert('Format file tidak didukung. Gunakan JPEG, PNG, JPG, GIF, atau WEBP.');
            e.target.value = '';
            preview.classList.add('hidden');
            return;
        }
        
        // Validate file size (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file terlalu besar. Maksimal 2MB.');
            e.target.value = '';
            preview.classList.add('hidden');
            return;
        }
        
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