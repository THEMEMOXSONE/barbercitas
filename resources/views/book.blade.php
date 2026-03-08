<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agendar Cita - {{ $settings->name ?? 'Barber Shop' }}</title>
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
</head>
<body class="antialiased bg-barber-900 text-barber-50 min-h-screen flex items-center justify-center p-4">

    <div class="flex flex-col lg:flex-row gap-6 max-w-5xl w-full">
        <!-- Main Booking Form Card -->
        <div class="flex-1 bg-[#181818] rounded-2xl shadow-2xl overflow-hidden border border-white/10">
            <div class="p-8">
                <div class="text-center mb-8">
                    <a href="/" class="text-barber-accent hover:text-white transition-colors text-sm font-semibold tracking-wider uppercase mb-4 inline-block">&larr; Volver al inicio</a>
                    <h1 class="text-3xl font-display font-bold text-white mb-2">Agendar Cita</h1>
                    <p class="text-gray-400 text-sm">Reserva tu espacio rápido y seguro.</p>
                </div>

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-900/50 border border-red-500 rounded-lg text-red-200 text-sm">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('book.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    @guest
                    <div>
                        <label for="guest_name" class="block text-sm font-medium text-gray-300 mb-2">Tu Nombre</label>
                        <input type="text" name="guest_name" id="guest_name" required value="{{ old('guest_name') }}" class="w-full px-4 py-3 bg-black/50 border border-white/10 rounded-lg focus:ring-2 focus:ring-barber-accent focus:border-transparent text-white placeholder-gray-500 transition-colors" placeholder="Ej. Juan Pérez">
                    </div>
                    @endguest

                    @auth
                    <!-- The controller uses Auth user name, show it as readonly -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Reservando a nombre de</label>
                        <input type="text" readonly value="{{ Auth::user()->name }}" class="w-full px-4 py-3 bg-black/20 border border-white/5 opacity-70 rounded-lg text-gray-300 cursor-not-allowed">
                    </div>
                    @endauth

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="appointment_date" class="block text-sm font-medium text-gray-300 mb-2">Fecha</label>
                            <input type="date" name="appointment_date" id="appointment_date" required min="{{ date('Y-m-d') }}" value="{{ old('appointment_date') }}" class="w-full px-4 py-3 bg-black/50 border border-white/10 rounded-lg focus:ring-2 focus:ring-barber-accent focus:border-transparent text-white transition-colors [color-scheme:dark]">
                        </div>
                        <div>
                            <label for="appointment_time" class="block text-sm font-medium text-gray-300 mb-2">Hora</label>
                            <input type="time" name="appointment_time" id="appointment_time" required value="{{ old('appointment_time') }}" class="w-full px-4 py-3 bg-black/50 border border-white/10 rounded-lg focus:ring-2 focus:ring-barber-accent focus:border-transparent text-white transition-colors [color-scheme:dark]">
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent rounded-lg shadow-sm text-base font-bold text-barber-900 bg-barber-accent hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-barber-accent focus:ring-offset-barber-900 transition-colors uppercase tracking-wide">
                            Confirmar Reserva
                        </button>
                    </div>
                </form>
                
                @guest
                <div class="mt-8 pt-6 border-t border-white/10 text-center">
                    <p class="text-sm text-gray-400">¿Eres cliente frecuente?</p>
                    <div class="mt-3 flex gap-4 justify-center">
                        <a href="{{ route('login') }}" class="text-barber-accent hover:text-white transition-colors text-sm font-medium">Inicia sesión</a>
                        <span class="text-gray-600">|</span>
                        <a href="{{ route('register') }}" class="text-barber-accent hover:text-white transition-colors text-sm font-medium">Regístrate</a>
                    </div>
                </div>
                @endguest
            </div>
        </div>

        <!-- Busy Hours Side Card -->
        @if(isset($busyAppointments) && count($busyAppointments) > 0)
        <div class="lg:w-80 bg-[#181818] rounded-2xl shadow-2xl overflow-hidden border border-white/10 flex flex-col h-auto">
            <div class="p-6 border-b border-white/10 bg-black/20">
                <h4 class="text-sm font-bold text-white uppercase tracking-wider flex items-center">
                    <svg class="w-4 h-4 mr-2 text-barber-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Horarios Ocupados
                </h4>
                <p class="text-xs text-gray-400 mt-1">Estos bloques ya no están disponibles.</p>
            </div>
            <div class="p-6 overflow-y-auto max-h-[400px]">
                <div class="space-y-3">
                    @php
                        $groupedByDate = $busyAppointments->groupBy('appointment_date');
                    @endphp
                    @foreach($groupedByDate as $date => $appointments)
                        <div class="mb-4">
                            <h5 class="text-xs font-semibold text-gray-300 mb-2 border-b border-white/5 pb-1">{{ \Carbon\Carbon::parse($date)->isoFormat('dddd D \d\e MMMM') }}</h5>
                            <div class="flex flex-wrap gap-2">
                                @foreach($appointments as $ba)
                                    <span class="inline-flex items-center px-2 py-1 bg-red-900/20 text-red-300 text-xs font-medium rounded border border-red-500/20">
                                        {{ \Carbon\Carbon::parse($ba->appointment_time)->format('h:i A') }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</body>
</html>
