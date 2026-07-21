<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-950 text-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Web Programming III - Practice Exercises')</title>
    <!-- Google Fonts: Outfit & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
        }
    </style>
    
    <!-- Tailwind CSS via CDN (Bypasses Node.js version conflicts) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        slate: {
                            850: '#1e293b',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="flex flex-col min-h-full">

    <!-- Header / Navbar -->
    <header class="sticky top-0 z-50 backdrop-blur-md bg-slate-950/80 border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo / Title -->
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg shadow-indigo-500/20">
                        <span class="text-white font-extrabold text-sm">WP</span>
                    </div>
                    <div>
                        <span class="text-lg font-bold bg-clip-text text-transparent bg-gradient-to-r from-white via-slate-200 to-slate-400">Alaqsa University</span>
                        <span class="hidden sm:inline-block text-xs text-indigo-400 ml-2 px-2 py-0.5 rounded-full bg-indigo-500/10 border border-indigo-500/20">Web Programming III</span>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="flex space-x-1 sm:space-x-2">
                    <a href="/" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ Request::is('/') ? 'bg-indigo-600/20 text-indigo-400 border border-indigo-500/30' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                        Home
                    </a>
                    <a href="/about" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ Request::is('about') ? 'bg-indigo-600/20 text-indigo-400 border border-indigo-500/30' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                        Week 1: About
                    </a>
                    <a href="/students" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ Request::is('students') ? 'bg-indigo-600/20 text-indigo-400 border border-indigo-500/30' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                        Week 2: Students List
                    </a>
                    <a href="/students-relationships" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ Request::is('students-relationships') ? 'bg-indigo-600/20 text-indigo-400 border border-indigo-500/30' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                        Weeks 3-4: ERD & Relationships
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="flex-grow py-8 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="mt-auto border-t border-slate-800 bg-slate-950 py-6 text-center text-xs text-slate-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p>&copy; 2026 Alaqsa University. Built for Web Programming III Practice Assignment.</p>
        </div>
    </footer>

</body>
</html>
