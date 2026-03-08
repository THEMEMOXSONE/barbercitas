<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cita Confirmada</title>
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

    <div class="max-w-sm w-full bg-[#181818] rounded-2xl shadow-2xl overflow-hidden border border-white/10 relative">
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-red-500 via-yellow-500 to-green-500"></div>
        <div class="p-8 text-center">
            
            <div class="w-20 h-20 bg-green-500/10 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <h1 class="text-3xl font-display font-bold text-white mb-2">¡Cita Guardada!</h1>
            <p class="text-gray-400 mb-8">Te esperamos el día de tu cita. Por favor sé puntual.</p>

            <div class="bg-black/40 rounded-xl p-5 mb-8 border border-white/5 text-left">
                <div class="mb-4">
                    <span class="block text-xs text-gray-500 uppercase tracking-wider mb-1">A nombre de</span>
                    <span class="block text-lg font-medium text-white">{{ $appointment->guest_name }}</span>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <span class="block text-xs text-gray-500 uppercase tracking-wider mb-1">Fecha</span>
                        <span class="block text-lg font-medium text-white">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d / m / Y') }}</span>
                    </div>
                    <div>
                        <span class="block text-xs text-gray-500 uppercase tracking-wider mb-1">Hora</span>
                        <span class="block text-lg font-medium text-white">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-red-500/10 border border-red-500/20 rounded-xl p-4 mb-8">
                <div class="flex items-center justify-center gap-2 mb-2 text-red-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <span class="font-bold text-sm uppercase tracking-wider">¡Importante!</span>
                </div>
                <p class="text-red-200 text-sm font-medium">TOMA SCREENSHOT A ESTA PANTALLA</p>
            </div>

            <a href="/" class="inline-block text-barber-accent hover:text-white transition-colors text-sm font-medium">&larr; Volver al inicio</a>
        </div>
    </div>
</body>
</html>
