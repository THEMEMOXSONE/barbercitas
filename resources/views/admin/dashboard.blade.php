<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 bg-red-100 border border-red-500 rounded text-red-700">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Walk-In Form -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full">
                    <div class="p-6 bg-yellow-500 border-b border-gray-200 h-full">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Registrar Walk-In Rápido</h3>
                        <p class="text-xs text-yellow-900 mb-4">Usa esto cuando un cliente llegue sin cita y pase directo a la silla.</p>
                        
                        <form action="{{ route('admin.walkin.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-900">Nombre del Cliente</label>
                                <input type="text" name="guest_name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-900 focus:ring-yellow-900 sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-900">Precio Cobrado ($)</label>
                                <input type="number" step="0.01" name="final_price" required value="{{ $settings->base_price ?? 0 }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                            </div>
                            <button type="submit" class="w-full bg-gray-900 text-white font-bold py-2 px-4 rounded hover:bg-black transition-colors">
                                Registrar Cobro
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Barber Settings -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium mb-4">Ajustes de la Barbería</h3>
                        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nombre del Local</label>
                                <input type="text" name="name" required value="{{ $settings->name ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Años Experiencia</label>
                                <input type="number" name="experience_years" required value="{{ $settings->experience_years ?? 0 }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Precio Base Citas</label>
                                <input type="number" step="0.01" name="base_price" required value="{{ $settings->base_price ?? 0 }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Biografía</label>
                                <textarea name="bio" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm sm:text-sm">{{ $settings->bio ?? '' }}</textarea>
                            </div>
                            <button type="submit" class="bg-blue-600 text-white font-medium py-2 px-4 rounded hover:bg-blue-700">
                                Guardar Ajustes
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Appointments List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Todas las Citas y Walk-ins</h3>
                        
                        <div class="flex gap-2">
                            <a href="{{ route('admin.report', ['days' => 1]) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Corte de Caja (Hoy)
                            </a>
                            <a href="{{ route('admin.report', ['days' => 7]) }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Reporte (7 Días)
                            </a>
                        </div>
                    </div>
                    
                    @if($appointments->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha / Hora</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detalles</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estatus</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($appointments as $apt)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $apt->guest_name }}</div>
                                                <div class="text-xs text-gray-500">{{ $apt->user_id && !$apt->is_walk_in ? 'Usuario Registrado' : 'Invitado/WalkIn' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($apt->appointment_date)->format('d/m/Y') }}</div>
                                                <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($apt->appointment_time)->format('h:i A') }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($apt->is_walk_in)
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Walk-In</span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Cita Online</span>
                                                @endif
                                                @if($apt->status == 'completed')
                                                    <div class="text-sm font-bold mt-1 text-green-600">Cobrado: ${{ $apt->final_price }}</div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($apt->status == 'pending')
                                                    <span class="bg-gray-100 text-gray-800 text-xs font-semibold px-2.5 py-0.5 rounded">Pendiente</span>
                                                @elseif($apt->status == 'completed')
                                                    <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">Completado</span>
                                                @else
                                                    <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">Cancelada</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                @if($apt->status == 'pending')
                                                    <form action="{{ route('admin.appointments.complete', $apt->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Completar y cobrar esta cita?');">
                                                        @csrf
                                                        <input type="number" step="0.01" name="final_price" required value="{{ $settings->base_price ?? 0 }}" class="w-20 text-xs p-1 border border-gray-300 rounded mr-1">
                                                        <button type="submit" class="text-green-600 hover:text-green-900 mr-3">Cobrar</button>
                                                    </form>
                                                    
                                                    <form action="{{ route('admin.appointments.cancel', $apt->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Cancelar esta cita?');">
                                                        @csrf
                                                        <button type="submit" class="text-red-600 hover:text-red-900">Cancelar</button>
                                                    </form>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">No hay citas registradas en el sistema.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
