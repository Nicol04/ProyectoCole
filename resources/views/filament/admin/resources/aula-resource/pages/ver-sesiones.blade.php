<x-filament::page>
    <x-filament::card>
        <x-filament::button tag="a"
            href="{{ route('filament.dashboard.resources.aulas.crear-sesion', ['record' => $aula->id, 'cursoId' => $curso->id]) }}"
            color="primary" class="mb-4">
            Crear Sesión
        </x-filament::button>
        <h2 class="text-xl font-bold mb-4">
            Sesiones de {{ $curso->curso }} en el Aula {{ $aula->grado }} {{ $aula->seccion }}
        </h2>

        <ul class="space-y-2">
            @forelse ($sesiones as $sesion)
                <li class="border p-3 rounded shadow-sm">
                    <strong>{{ $sesion->titulo }}</strong><br>
                    Fecha: {{ $sesion->fecha }} - Día: {{ $sesion->dia }}<br>
                    Objetivo: {{ $sesion->objetivo }}<br>
                    Actividades: {{ $sesion->actividades }}<br>

                    @if ($aula->docente)
                        <p class="mb-4">
                            <strong>Docente:</strong>
                            {{ $aula->docente->persona->nombre ?? $aula->docente->name }}
                            {{ $aula->docente->persona->apellido ?? '' }}
                        </p>
                    @endif

                    <x-filament::button tag="a"
                        href="{{ route('filament.dashboard.resources.aulas.editar-sesion', ['record' => $sesion->id]) }}"
                        color="secondary">
                        Editar
                    </x-filament::button>
                </li>
            @empty
                <li>No hay sesiones registradas.</li>
            @endforelse
        </ul>

    </x-filament::card>
</x-filament::page>
