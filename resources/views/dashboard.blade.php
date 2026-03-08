<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tu Panel - Barber Shop</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800|outfit:500,700,900" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        barber: {
                            50: '#f6f6f6',
                            100: '#e7e7e7',
                            900: '#111111',
                            accent: '#dca54c'
                        }
                    }
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="antialiased bg-barber-900 text-barber-50 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-[#141414] border-b border-white/10" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex-shrink-0">
                    <a href="/" class="font-display font-bold text-xl tracking-tight text-white uppercase hover:text-barber-accent transition-colors">STYLE & CUTS</a>
                </div>
                <div class="hidden md:block">
                    <div class="ml-4 flex items-center md:ml-6">
                        <div class="relative ml-3" x-data="{ dropdownOpen: false }">
                            <div>
                                <button @click="dropdownOpen = !dropdownOpen" type="button" class="flex max-w-xs items-center rounded-full bg-barber-900 text-sm focus:outline-none focus:ring-2 focus:ring-barber-accent focus:ring-offset-2 focus:ring-offset-barber-900 px-4 py-2 border border-white/10 text-gray-300 hover:text-white transition-colors" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <span class="mr-2">{{ Auth::user()->name }}</span>
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                            </div>
                            <!-- Dropdown -->
                            <div x-show="dropdownOpen" @click.away="dropdownOpen = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1" style="display: none;">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1">Mi Perfil</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100" role="menuitem" tabindex="-1">Cerrar Sesión</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Mobile menu button -->
                <div class="-mr-2 flex md:hidden">
                    <button @click="open = !open" type="button" class="inline-flex items-center justify-center rounded-md bg-barber-900 p-2 text-gray-400 hover:bg-gray-800 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="block h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div class="md:hidden" id="mobile-menu" x-show="open" style="display: none;">
            <div class="border-t border-white/10 pb-3 pt-4">
                <div class="flex items-center px-5">
                    <div class="ml-3">
                        <div class="text-base font-medium leading-none text-white">{{ Auth::user()->name }}</div>
                        <div class="mt-1 text-sm font-medium leading-none text-gray-400">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <div class="mt-3 space-y-1 px-2">
                    <a href="{{ route('profile.edit') }}" class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-800 hover:text-white">Mi Perfil</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left rounded-md px-3 py-2 text-base font-medium text-red-400 hover:bg-gray-800 hover:text-red-300">Cerrar Sesión</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-display font-bold text-white mb-2">Mi Historial de Citas</h1>
                <p class="text-gray-400">Gestiona tus próximas citas o agenda una nueva.</p>
            </div>
            <a href="{{ route('book') }}" class="mt-4 md:mt-0 px-6 py-3 bg-barber-accent hover:bg-yellow-500 text-barber-900 font-bold uppercase tracking-wider rounded-lg transition-colors shadow-lg shadow-barber-accent/20">
                + Nueva Cita
            </a>
        </div>

        @if (session('success'))
            <div class="mb-8 bg-green-900/50 border border-green-500 text-green-200 px-6 py-4 rounded-lg relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-[#181818] rounded-2xl shadow-2xl overflow-hidden border border-white/10">
            <div class="p-8">
                
                @if($appointments->count() > 0)
                    <div class="space-y-4">
                        @foreach($appointments as $apt)
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-5 bg-black/40 border border-white/5 rounded-xl hover:border-white/10 transition-colors">
                            <div class="mb-4 sm:mb-0">
                                <span class="block text-xs text-barber-accent uppercase tracking-wider mb-2">Cita para {{ $apt->guest_name ?? Auth::user()->name }}</span>
                                <div class="flex items-center gap-6 text-white font-medium">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        {{ \Carbon\Carbon::parse($apt->appointment_date)->format('d / m / Y') }}
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ \Carbon\Carbon::parse($apt->appointment_time)->format('h:i A') }}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-4 w-full sm:w-auto justify-between sm:justify-end">
                                @if($apt->status == 'pending')
                                    <span class="px-3 py-1 bg-blue-900/50 text-blue-200 border border-blue-500/30 rounded-full text-xs font-medium tracking-wide">Pendiente</span>
                                    <form action="{{ route('book.destroy', $apt->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas cancelar esta cita?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm font-medium text-red-500 hover:text-red-400 hover:underline px-2 transition-colors">Cancelar Cita</button>
                                    </form>
                                @elseif($apt->status == 'completed')
                                    <span class="px-3 py-1 bg-green-900/50 text-green-200 border border-green-500/30 rounded-full text-xs font-medium tracking-wide">Completado</span>
                                @else
                                    <span class="px-3 py-1 bg-red-900/50 text-red-200 border border-red-500/30 rounded-full text-xs font-medium tracking-wide">Cancelada</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-16 bg-black/20 rounded-xl border border-dashed border-white/10">
                        <svg class="mx-auto h-12 w-12 text-gray-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-white mb-1">Sin historial disponible</h3>
                        <p class="text-gray-400 mb-6">Aún no tienes citas agendadas.</p>
                        <a href="{{ route('book') }}" class="inline-block px-4 py-2 border border-barber-accent text-barber-accent hover:bg-barber-accent hover:text-barber-900 rounded-full transition-colors font-medium">Agendar mi primera cita &rarr;</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
