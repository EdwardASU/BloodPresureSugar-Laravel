<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Blood Monitor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: { DEFAULT: '#6366f1', dark: '#4f46e5' }
                    }
                }
            }
        }
    </script>
    <style>
        .sidebar-link { @apply flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium text-gray-400 hover:text-white hover:bg-white/10 transition-all; }
        .sidebar-link.active { @apply text-white bg-white/10; }
        [x-cloak] { display: none !important; }
    </style>
    @livewireStyles
</head>
<body class="h-full flex bg-gray-950 text-white">

{{-- Sidebar --}}
<aside class="w-64 flex-shrink-0 flex flex-col bg-gray-900 border-r border-white/5">
    <div class="h-16 flex items-center px-6 border-b border-white/5">
        <span class="text-lg font-bold tracking-tight">
            <span class="text-indigo-400">Blood</span>Monitor
        </span>
    </div>

    <nav class="flex-1 px-3 py-6 flex flex-col gap-1">
        <a href="{{ route('admin.dashboard') }}"
           class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Dashboard
        </a>

        <a href="{{ route('admin.users.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Users
        </a>

        <a href="{{ route('admin.blood-sugars.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.blood-sugars.*') ? 'active' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
            </svg>
            Blood Sugar
        </a>

        <a href="{{ route('admin.blood-pressures.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.blood-pressures.*') ? 'active' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
            Blood Pressure
        </a>
    </nav>

    <div class="p-4 border-t border-white/5">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-xs font-bold">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="min-w-0">
                <p class="text-sm font-medium truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('admin.logout') }}"
              onsubmit="return confirm('Confirm logout?')">
            @csrf
            <button class="w-full text-left text-xs text-gray-500 hover:text-red-400 transition-colors px-1">
                Sign out →
            </button>
        </form>
    </div>
</aside>

{{-- Main content --}}
<main class="flex-1 flex flex-col overflow-hidden bg-gray-950">

    <div class="flex-1 overflow-y-auto p-8">
        @if(session('success'))
            <div class="mb-6 flex items-center gap-3 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm px-4 py-3 rounded-lg">
                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
        @endif

        {{ $slot }}
    </div>
</main>

@livewireScripts
</body>
</html>
