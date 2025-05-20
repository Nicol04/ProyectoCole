<x-filament::page>
    <x-filament::card>
        <h2 class="text-xl font-bold mb-4">
            Sesiones de {{ $curso->curso }} en el Aula {{ $aula->nombre }}
        </h2>

        <ul class="space-y-2">
            @forelse ($sesiones as $sesion)
                <li class="border p-3 rounded shadow-sm">
                    <strong>{{ $sesion->titulo }}</strong><br>
                    Fecha: {{ $sesion->fecha }} - Día: {{ $sesion->dia }}<br>
                    Objetivo: {{ $sesion->objetivo }}<br>
                    Actividades: {{ $sesion->actividades }}<br>
                </li>
            @empty
                <li>No hay sesiones registradas.</li>
            @endforelse
        </ul>
    </x-filament::card>
</x-filament::page>
