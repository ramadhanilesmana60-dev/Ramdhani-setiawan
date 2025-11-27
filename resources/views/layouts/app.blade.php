<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'E-Mading')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        secondary: '#1E40AF'
                    }
                }
            }
        }
    </script>
    @stack('styles')
    <style>
        .loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #3B82F6, #1E40AF);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.5s ease-out;
        }
        .loader.hidden {
            opacity: 0;
            pointer-events: none;
        }
        .spinner {
            width: 60px;
            height: 60px;
            border: 4px solid rgba(255,255,255,0.3);
            border-top: 4px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .loader-text {
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Loading Screen -->
    <div id="loader" class="loader">
        <div class="text-center">
            <div class="spinner mx-auto"></div>
            <div class="loader-text">E-Mading</div>
        </div>
    </div>
    <nav class="bg-white shadow-lg border-b-2 border-primary">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-primary">E-Mading</a>
                
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-primary hover:text-secondary">Dashboard</a>
                        <a href="{{ route('profile') }}" class="text-primary hover:text-secondary">Profile</a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button class="bg-primary text-white px-4 py-2 rounded hover:bg-secondary">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-primary hover:text-secondary">Login</a>
                        <a href="{{ route('register') }}" class="bg-primary text-white px-4 py-2 rounded hover:bg-secondary">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>
    
    @stack('scripts')
    <script>
        window.addEventListener('load', function() {
            setTimeout(function() {
                document.getElementById('loader').classList.add('hidden');
                setTimeout(function() {
                    document.getElementById('loader').style.display = 'none';
                }, 500);
            }, 800);
        });
    </script>
</body>
</html>