@extends('layouts.app')

@section('title', 'E-Mading Sekolah')

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    .float-animation {
        animation: float 3s ease-in-out infinite;
    }
    .hover-lift:hover {
        transform: translateY(-8px);
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<div class="relative bg-gradient-to-br from-blue-600 to-blue-800 rounded-2xl mb-12 overflow-hidden">
    <div class="absolute inset-0">
        <div class="absolute top-10 left-10 w-20 h-20 bg-white opacity-10 rounded-full float-animation"></div>
        <div class="absolute top-32 right-20 w-16 h-16 bg-white opacity-15 rounded-full float-animation" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-20 left-1/4 w-12 h-12 bg-white opacity-10 rounded-full float-animation" style="animation-delay: 2s;"></div>
        <div class="absolute bottom-10 right-10 w-24 h-24 bg-white opacity-5 rounded-full float-animation" style="animation-delay: 0.5s;"></div>
    </div>
    
    <div class="relative text-center py-20 px-8">
        <h1 class="text-5xl md:text-6xl font-bold text-white mb-6">
            E-Mading Sekolah
        </h1>
        <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
            Portal berita dan informasi sekolah yang modern dan interaktif
        </p>
        
        <!-- Search Bar -->
        <div class="max-w-2xl mx-auto">
            <form method="GET" action="{{ route('home') }}" class="relative">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari artikel..." 
                       class="w-full px-6 py-4 pr-16 text-lg border-0 rounded-full shadow-xl focus:outline-none focus:ring-4 focus:ring-white focus:ring-opacity-30 bg-white">
                <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-blue-600 text-white px-6 py-2 rounded-full hover:bg-blue-700 transition-all duration-300">
                    Cari
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Category Pills -->
<div class="flex flex-wrap justify-center gap-3 mb-12">
    <a href="{{ route('home') }}" class="px-6 py-3 rounded-full transition-all duration-300 {{ !request('kategori') ? 'bg-blue-600 text-white shadow-lg' : 'bg-white text-blue-600 border-2 border-blue-200 hover:border-blue-400 hover:shadow-md' }}">
        <span class="font-medium">Semua</span>
    </a>
    @foreach($kategoris as $kategori)
        <a href="{{ route('home', ['kategori' => $kategori->id]) }}" 
           class="px-6 py-3 rounded-full transition-all duration-300 {{ request('kategori') == $kategori->id ? 'bg-blue-600 text-white shadow-lg' : 'bg-white text-blue-600 border-2 border-blue-200 hover:border-blue-400 hover:shadow-md' }}">
            <span class="font-medium">{{ $kategori->nama_kategori }}</span>
        </a>
    @endforeach
</div>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
    <!-- Main Content -->
    <div class="lg:col-span-3">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @forelse($artikels as $artikel)
                <a href="{{ route('artikel.detail', $artikel->id) }}" class="block bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 cursor-pointer">
                    @if($artikel->foto)
                        <div class="relative overflow-hidden">
                            <img src="{{ asset('storage/' . $artikel->foto) }}" alt="{{ $artikel->judul }}" class="w-full h-56 object-cover transition-transform duration-300 hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                        </div>
                    @else
                        <div class="h-56 bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                            <div class="w-16 h-16 bg-blue-300 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold text-2xl">A</span>
                            </div>
                        </div>
                    @endif
                    
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <span class="bg-blue-600 text-white text-xs px-3 py-1 rounded-full font-medium">{{ $artikel->kategori->nama_kategori }}</span>
                            <span class="text-gray-400 text-sm">{{ $artikel->tanggal }}</span>
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2 hover:text-blue-600 transition-colors">{{ $artikel->judul }}</h3>
                        <p class="text-gray-600 mb-4 line-clamp-3">{{ Str::limit(strip_tags($artikel->isi), 120) }}</p>
                        
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-full overflow-hidden">
                                    @if($artikel->user->foto)
                                        <img src="{{ asset('storage/' . $artikel->user->foto) }}" alt="{{ $artikel->user->nama }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-blue-100 flex items-center justify-center">
                                            <span class="text-blue-600 font-semibold text-sm">{{ substr($artikel->user->nama, 0, 1) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-700">{{ $artikel->user->nama }}</span>
                                    <div class="flex items-center space-x-3 text-xs text-gray-500">
                                        @auth
                                            <form action="{{ route('artikel.like', $artikel->id) }}" method="POST" class="inline like-form" onclick="event.stopPropagation()">
                                                @csrf
                                                <button type="submit" class="flex items-center space-x-1 hover:text-blue-600 transition-colors like-btn {{ isset($artikel->user_liked) && $artikel->user_liked ? 'text-red-500' : 'text-gray-400' }}">
                                                    <span>♥</span>
                                                    <span class="like-count">{{ $artikel->likes->count() }}</span>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('artikel.public-like', $artikel->id) }}" method="POST" class="inline like-form" onclick="event.stopPropagation()">
                                                @csrf
                                                <button type="submit" class="flex items-center space-x-1 hover:text-blue-600 transition-colors like-btn {{ $artikel->likes->where('ip_address', request()->ip())->whereNull('user_id')->count() > 0 ? 'text-red-500' : 'text-gray-400' }}">
                                                    <span>♥</span>
                                                    <span class="like-count">{{ $artikel->likes->count() }}</span>
                                                </button>
                                            </form>
                                        @endauth
                                        <span class="flex items-center"><span class="mr-1">💬</span>{{ $artikel->komentars->count() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-16">
                    <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-gray-400 font-bold text-3xl">?</span>
                    </div>
                    <p class="text-gray-500 text-lg">Belum ada artikel yang dipublikasikan</p>
                </div>
            @endforelse
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="lg:col-span-1 space-y-8">
        <div class="sticky top-8 space-y-8">
        <!-- Artikel Populer -->
        <div class="bg-white rounded-2xl shadow-xl p-6">
            <div class="flex items-center mb-6">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                    <span class="text-blue-600 font-bold">★</span>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Artikel Populer</h3>
            </div>
            @forelse($artikelPopuler as $artikel)
                <div class="flex items-start space-x-3 mb-4 pb-4 border-b border-gray-100 last:border-b-0 hover:bg-blue-50 p-2 rounded-lg transition-colors">
                    <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0 overflow-hidden">
                        @if($artikel->foto)
                            <img src="{{ asset('storage/' . $artikel->foto) }}" alt="{{ $artikel->judul }}" class="w-full h-full object-cover rounded-xl">
                        @else
                            <span class="text-blue-400 font-bold text-lg">A</span>
                        @endif
                    </div>
                    <div class="flex-1">
                        <a href="{{ route('artikel.detail', $artikel->id) }}" class="text-sm font-semibold text-gray-800 hover:text-blue-600 line-clamp-2 transition-colors">
                            {{ $artikel->judul }}
                        </a>
                        <div class="text-xs text-gray-500 mt-2 flex items-center space-x-3">
                            <span class="flex items-center">
                                <span class="mr-1">💬</span>
                                {{ $artikel->komentars->count() }}
                            </span>
                            <span class="flex items-center">
                                <span class="mr-1 {{ isset($artikel->user_liked) && $artikel->user_liked ? 'text-red-500' : 'text-gray-400' }}">♥</span>
                                {{ $artikel->likes->count() }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-2">
                        <span class="text-gray-400 font-bold text-xl">★</span>
                    </div>
                    <p class="text-gray-500 text-sm">Belum ada artikel populer</p>
                </div>
            @endforelse
        </div>
        
        <!-- Kategori -->
        <div class="bg-white rounded-2xl shadow-xl p-6">
            <div class="flex items-center mb-6">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                    <span class="text-blue-600 font-bold">#</span>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Kategori</h3>
            </div>
            <div class="space-y-2">
                @foreach($kategoris as $kategori)
                    <a href="{{ route('home', ['kategori' => $kategori->id]) }}" 
                       class="flex items-center justify-between py-3 px-4 text-gray-700 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all duration-200 group">
                        <span class="font-medium">{{ $kategori->nama_kategori }}</span>
                        <span class="bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded-full font-medium">{{ $kategori->artikels->where('status', 'published')->count() }}</span>
                    </a>
                @endforeach
            </div>
        </div>
        </div>
    </div>
</div>

<!-- Copyright Footer -->
<footer class="mt-16 py-8 border-t border-gray-200">
    <div class="text-center text-gray-600">
        <p>&copy; {{ date('Y') }} E-Mading Sekolah. All rights reserved.</p>
    </div>
</footer>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const likeForms = document.querySelectorAll('.like-form');
    
    likeForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const btn = this.querySelector('.like-btn');
            const countSpan = this.querySelector('.like-count');
            const currentCount = parseInt(countSpan.textContent);
            
            // Toggle color and count
            if (btn.classList.contains('text-red-500')) {
                btn.classList.remove('text-red-500');
                btn.classList.add('text-gray-400');
                countSpan.textContent = currentCount - 1;
            } else {
                btn.classList.remove('text-gray-400');
                btn.classList.add('text-red-500');
                countSpan.textContent = currentCount + 1;
            }
            
            // Submit form in background
            fetch(this.action, {
                method: 'POST',
                body: new FormData(this),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
        });
    });
});
</script>
@endpush