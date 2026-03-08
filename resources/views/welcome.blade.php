<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $settings->name ?? 'Barber Shop' }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800|outfit:500,700,900" rel="stylesheet" />
    <!-- Scripts / Styles -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
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
    @endif
    <style>
        .glass {
            background: rgba(17, 17, 17, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>

<body class="antialiased bg-barber-900 text-barber-50 selection:bg-barber-accent selection:text-white">

    <!-- Navigation -->
    <nav class="fixed w-full z-50 glass">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex-shrink-0 flex items-center gap-2">
                    <span
                        class="font-display font-bold text-2xl tracking-tight text-white uppercase">{{ $settings->name ?? 'STYLE & CUTS' }}</span>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-8">
                        <a href="#about"
                            class="text-gray-300 hover:text-barber-accent px-3 py-2 rounded-md text-sm font-medium transition-colors">About</a>
                        <a href="#portfolio"
                            class="text-gray-300 hover:text-barber-accent px-3 py-2 rounded-md text-sm font-medium transition-colors">Gallery</a>
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="text-white bg-white/10 hover:bg-white/20 px-4 py-2 rounded-md text-sm font-medium transition-colors">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}"
                                class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">Log
                                in</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative min-h-screen flex items-center justify-center pt-20 overflow-hidden">
        <!-- Background Image overlay -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1599351431202-1e0f0137899a?q=80&w=2672&auto=format&fit=crop"
                class="w-full h-full object-cover" alt="Barber Shop Background" />
            <div class="absolute inset-0 bg-gradient-to-t from-barber-900 via-barber-900/60 to-transparent"></div>
        </div>

        <div class="relative z-10 text-center px-4 max-w-4xl mx-auto mt-10">
            <span class="text-barber-accent font-semibold tracking-wider uppercase text-sm mb-4 block">Premium Grooming
                Experience</span>
            <h1 class="text-5xl md:text-7xl font-display font-black text-white mb-6 tracking-tight leading-tight">
                Sharp Looks, <br />
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-barber-accent to-yellow-200">Classic
                    Style.</span>
            </h1>
            <p class="mt-4 text-xl text-gray-300 mb-10 max-w-2xl mx-auto font-light">
                {{ $settings->bio ?? 'Step into a world of classic grooming and modern styling. Professional cuts, straight razor shaves, and top-tier service.' }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="/book"
                    class="group relative inline-flex items-center justify-center px-8 py-4 text-lg font-bold text-barber-900 transition-all duration-200 bg-barber-accent rounded-full hover:bg-yellow-500 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-barber-accent shadow-[0_0_20px_rgba(220,165,76,0.4)]">
                    Agendar Cita
                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
                <a href="#about"
                    class="px-8 py-4 text-lg font-medium text-white transition-all duration-200 rounded-full border border-white/20 hover:bg-white/10 hover:border-white/40">
                    Know More
                </a>
            </div>

            <div class="mt-20 grid grid-cols-2 md:grid-cols-4 gap-8 border-t border-white/10 pt-10">
                <div class="text-center">
                    <p class="text-3xl font-display font-bold text-white">{{ $settings->experience_years ?? '5' }}+</p>
                    <p class="text-sm text-gray-400 mt-1 uppercase tracking-wider">Years Experience</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-display font-bold text-white">
                        ${{ number_format($settings->base_price ?? 15, 0) }}</p>
                    <p class="text-sm text-gray-400 mt-1 uppercase tracking-wider">Starting Price</p>
                </div>
                <div class="text-center hidden md:block">
                    <p class="text-3xl font-display font-bold text-white">4.9</p>
                    <p class="text-sm text-gray-400 mt-1 uppercase tracking-wider">Star Rating</p>
                </div>
                <div class="text-center hidden md:block">
                    <p class="text-3xl font-display font-bold text-white">100%</p>
                    <p class="text-sm text-gray-400 mt-1 uppercase tracking-wider">Satisfaction</p>
                </div>
            </div>
        </div>
    </div>

    <!-- About Section -->
    <section id="about" class="py-24 bg-[#141414]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1622286342621-4bd786c2447c?q=80&w=2670&auto=format&fit=crop"
                        alt="Barber at work"
                        class="rounded-xl shadow-2xl filter grayscale hover:grayscale-0 transition-all duration-700 w-full h-auto object-cover aspect-[4/5]">
                    <div class="absolute -bottom-6 -right-6 bg-barber-accent p-6 rounded-lg shadow-xl">
                        <p class="text-barber-900 font-bold font-display text-xl">Top Quality</p>
                        <p class="text-barber-900/80 text-sm">Guranteed Results</p>
                    </div>
                </div>
                <div>
                    <h2 class="text-barber-accent text-lg text-white font-semibold tracking-wider uppercase mb-2">The
                        Barber</h2>
                    <h3 class="text-4xl font-display font-bold text-white mb-6">Master of the Craft</h3>
                    <p class="text-gray-400 text-lg leading-relaxed mb-6">
                        {{ $settings->bio ?? 'Bringing old-school barbering techniques into the modern era. We pride ourselves on attention to detail, precision cutting, and an atmosphere that makes every client feel like a VIP.' }}
                    </p>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center text-gray-300">
                            <span class="w-2 h-2 bg-barber-accent rounded-full mr-3"></span>
                            Precision Haircuts & Styling
                        </li>
                        <li class="flex items-center text-gray-300">
                            <span class="w-2 h-2 bg-barber-accent rounded-full mr-3"></span>
                            Hot Towel Straight Razor Shaves
                        </li>
                        <li class="flex items-center text-gray-300">
                            <span class="w-2 h-2 bg-barber-accent rounded-full mr-3"></span>
                            Beard Trimming & Grooming
                        </li>
                    </ul>
                    <a href="/book"
                        class="inline-block px-6 py-3 border-2 border-barber-accent text-barber-accent font-medium text-white rounded-full hover:bg-barber-accent hover:text-barber-900 transition-colors">Book
                        Your Spot</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Portfolio Gallery -->
    <section id="portfolio" class="py-24 bg-barber-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-barber-accent text-lg font-semibold tracking-wider uppercase mb-2">Our Work</h2>
            <h3 class="text-4xl font-display font-bold text-white mb-16">Signature Cuts</h3>

            @if($images && $images->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($images as $image)
                        <div class="group relative overflow-hidden rounded-xl aspect-[4/5] bg-gray-800">
                            <img src="{{ Storage::url($image->image_path) }}" alt="{{ $image->description }}"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-6 text-left">
                                <p class="text-white font-medium text-lg">{{ $image->description ?? 'Fresh Cut' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Demo Images if table is empty -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="group relative overflow-hidden rounded-xl aspect-square bg-gray-800">
                        <img src="https://images.unsplash.com/photo-1585747860715-2ba37e788b70?q=80&w=2674&auto=format&fit=crop"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 filter grayscale group-hover:grayscale-0">
                    </div>
                    <div class="group relative overflow-hidden rounded-xl aspect-square bg-gray-800">
                        <img src="https://images.unsplash.com/photo-1621644026871-36baeb687355?q=80&w=2670&auto=format&fit=crop"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 filter grayscale group-hover:grayscale-0">
                    </div>
                    <div class="group relative overflow-hidden rounded-xl aspect-square bg-gray-800">
                        <img src="https://images.unsplash.com/photo-1593702288056-ccbfbfaefa92?q=80&w=2670&auto=format&fit=crop"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 filter grayscale group-hover:grayscale-0">
                    </div>
                </div>
            @endif

            <div class="mt-16 text-center">
                <a href="#book"
                    class="inline-flex items-center justify-center px-8 py-4 text-base font-bold text-white transition-all duration-200 bg-white/5 rounded-full hover:bg-white/10 ring-1 ring-white/20">
                    View Full Gallery
                </a>
            </div>
        </div>
    </section>

    <!-- Footer CTA -->
    <footer class="bg-black py-12 border-t border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-gray-500">
            <h2 class="text-2xl font-display font-medium text-white mb-6">Ready to upgrade your style?</h2>
            <a href="/book"
                class="inline-block px-10 py-3 mb-10 bg-barber-accent text-barber-900 font-bold uppercase tracking-wider rounded-sm hover:bg-yellow-500 transition-colors">Book
                Appointment Now</a>
            <p class="text-sm">© {{ date('Y') }} {{ $settings->name ?? 'Barber Shop' }}. Todos los derechos reservados.
            </p>
        </div>
    </footer>
</body>

</html>