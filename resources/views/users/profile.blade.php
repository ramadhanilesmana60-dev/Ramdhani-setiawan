@extends('layouts.app')

@section('title', 'Profile - E-Mading')

@push('styles')
<style>
    .gradient-bg {
        background: linear-gradient(135deg, #3B82F6 0%, #1E40AF 100%);
    }
    .card-hover {
        transition: all 0.3s ease;
    }
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(59, 130, 246, 0.2), 0 10px 10px -5px rgba(59, 130, 246, 0.1);
    }
    .profile-avatar {
        background: linear-gradient(135deg, #3B82F6, #1E40AF);
        box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-100">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text text-transparent mb-4">Profile Saya</h1>
            <p class="text-gray-600 text-lg">Kelola informasi personal Anda</p>
        </div>
        
        @if(session('success'))
            <div class="max-w-4xl mx-auto mb-6">
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-r-lg shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            </div>
        @endif

        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Profile Card -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden card-hover">
                        <div class="gradient-bg h-32 relative">
                            <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                        </div>
                        <div class="relative px-6 pb-6">
                            <div class="flex justify-center -mt-16 mb-4">
                                <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-white profile-avatar">
                                    @if($user->foto)
                                        <img src="{{ asset('storage/' . $user->foto) }}" alt="Profile" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <span class="text-white text-4xl font-bold">{{ strtoupper(substr($user->nama, 0, 1)) }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="text-center mb-6">
                                <h2 class="text-2xl font-bold text-gray-800 mb-1">{{ $user->nama }}</h2>
                                <p class="text-blue-600 font-medium">{{ ucfirst($user->role) }}</p>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-medium text-gray-500">Username</span>
                                        <span class="text-gray-800 font-semibold">{{ $user->username }}</span>
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-medium text-gray-500">Total Artikel</span>
                                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">{{ $artikels->count() }}</span>
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-medium text-gray-500">Published</span>
                                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">{{ $artikels->where('status', 'published')->count() }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-6">
                                <button onclick="toggleEditForm()" class="w-full bg-gradient-to-r from-blue-600 to-blue-800 text-white py-3 px-4 rounded-lg font-semibold hover:from-blue-700 hover:to-blue-900 transition-all duration-300 transform hover:scale-105 shadow-lg">
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Edit Profile
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Form (Hidden by default) -->
                <div class="lg:col-span-2">
                    <div id="editForm" class="bg-white rounded-2xl shadow-xl p-8 card-hover" style="display: none;">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-2xl font-bold text-gray-800">Edit Profile</h3>
                            <button onclick="toggleEditForm()" class="text-gray-500 hover:text-gray-700">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        
                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-6">
                                <label class="block text-gray-700 text-sm font-bold mb-3">Foto Profile</label>
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors">
                                    <input type="file" name="foto" accept="image/*" id="fotoInput" class="hidden" onchange="previewImage(this)">
                                    <label for="fotoInput" class="cursor-pointer">
                                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                        <p class="text-gray-600">Klik untuk upload foto</p>
                                        <p class="text-xs text-gray-500 mt-1">JPG, PNG, JPEG (Max: 2MB)</p>
                                    </label>
                                </div>
                                @error('foto')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
                                    <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nama') border-red-500 @enderror">
                                    @error('nama')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                                    <input type="text" name="username" value="{{ old('username', $user->username) }}" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('username') border-red-500 @enderror">
                                    @error('username')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mb-6">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Password Baru (Kosongkan jika tidak ingin mengubah)</label>
                                <div class="relative">
                                    <input type="password" name="password" id="password"
                                           class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror">
                                    <button type="button" onclick="togglePassword('password', 'eyeIcon')" 
                                            class="absolute inset-y-0 right-0 pr-4 flex items-center">
                                        <svg id="eyeIcon" class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="flex space-x-4">
                                <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-blue-800 text-white py-3 px-6 rounded-lg font-semibold hover:from-blue-700 hover:to-blue-900 transition-all duration-300 transform hover:scale-105 shadow-lg">
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Update Profile
                                </button>
                                <button type="button" onclick="toggleEditForm()" class="px-6 py-3 border border-blue-300 text-blue-700 rounded-lg hover:bg-blue-50 transition-colors">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- My Articles (Always visible) -->
                    <div id="articlesSection" class="bg-white rounded-2xl shadow-xl p-8 card-hover">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-2xl font-bold text-gray-800">Artikel Saya</h3>
                            <a href="{{ route('artikel.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                Lihat Semua
                            </a>
                        </div>
                        
                        @if($artikels->count() > 0)
                            <div class="space-y-4">
                                @foreach($artikels->take(5) as $artikel)
                                    <div class="bg-gradient-to-r from-blue-50 to-white rounded-lg p-4 border-l-4 border-blue-500 hover:shadow-md transition-all duration-300">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-gray-800 mb-2">{{ $artikel->judul }}</h4>
                                                <div class="flex items-center space-x-4 text-sm text-gray-600">
                                                    <span class="flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                        </svg>
                                                        {{ $artikel->tanggal }}
                                                    </span>
                                                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $artikel->status == 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                        {{ ucfirst($artikel->status) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <a href="{{ route('artikel.edit', $artikel->id) }}" class="ml-4 text-blue-600 hover:text-blue-800">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            @if($artikels->count() > 5)
                                <div class="mt-6 text-center">
                                    <a href="{{ route('artikel.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                                        Lihat {{ $artikels->count() - 5 }} artikel lainnya
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-12">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="text-gray-600 mb-4">Belum ada artikel yang dibuat</p>
                                <a href="{{ route('artikel.create') }}" class="inline-flex items-center bg-gradient-to-r from-blue-600 to-blue-800 text-white px-6 py-3 rounded-lg font-semibold hover:from-blue-700 hover:to-blue-900 transition-all duration-300 transform hover:scale-105 shadow-lg">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Buat Artikel Pertama
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleEditForm() {
    const editForm = document.getElementById('editForm');
    const articlesSection = document.getElementById('articlesSection');
    
    if (editForm.style.display === 'none') {
        editForm.style.display = 'block';
        articlesSection.style.display = 'none';
    } else {
        editForm.style.display = 'none';
        articlesSection.style.display = 'block';
    }
}

function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
        `;
    } else {
        input.type = 'password';
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        `;
    }
}

function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // You can add image preview functionality here if needed
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection