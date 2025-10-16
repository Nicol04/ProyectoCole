{{-- Componente reutilizable para formulario de competencias --}}
{{-- Acepta parámetros: $cursos, $competencias, $disableCursoSelect, $curso --}}

<div class="col-md-6 mb-3">
    <label for="curso_id" class="form-label">Curso</label>
    <select name="curso_id" class="form-control" id="curso-select"
        {{ $disableCursoSelect ?? false ? 'disabled' : '' }} required>
        <option value="">Seleccione un curso</option>
        @if(isset($cursos))
            @foreach ($cursos as $cursoItem)
                <option value="{{ $cursoItem->id }}"
                    {{ (old('curso_id') ?? ($curso->id ?? '')) == $cursoItem->id ? 'selected' : '' }}>
                    {{ $cursoItem->curso }}
                </option>
            @endforeach
        @endif
    </select>
</div>

<div class="col-md-6 mb-3">
    <label for="competencia_id" class="form-label">Competencias</label>
    <select name="competencia_id[]" class="form-control select2"
        id="competencia-select" multiple="multiple" required>
        @if ($competencias ?? false)
            @foreach ($competencias as $competencia)
                <option value="{{ $competencia->id }}">{{ $competencia->nombre }}</option>
            @endforeach
        @endif
    </select>
</div>

<div class="col-md-6 mb-3">
    <label for="capacidad_id" class="form-label">Capacidades</label>
    <select name="capacidad_id[]" class="form-control select2"
        id="capacidad-select" multiple="multiple" required>
        <!-- Las capacidades relacionadas se cargarán dinámicamente aquí -->
    </select>
</div>

<div class="col-md-6 mb-3">
    <label for="desempeno_id" class="form-label">Desempeños</label>
    <select name="desempeno_id[]" class="form-control select2"
        id="desempeno-select" multiple="multiple" required>
        <!-- Los desempeños relacionadas se cargarán dinámicamente aquí -->
    </select>
</div>

{{-- Script para la funcionalidad AJAX --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Evento para cambio de curso
    const cursoSelect = document.getElementById('curso-select');
    if (cursoSelect) {
        cursoSelect.addEventListener('change', function() {
            const cursoId = this.value;
            const competenciaSelect = document.getElementById('competencia-select');

            if (cursoId) {
                fetch(`/cursos/${cursoId}/competencias`)
                    .then(response => response.json())
                    .then(data => {
                        competenciaSelect.innerHTML = '<option value="">Seleccione una competencia</option>';
                        data.forEach(competencia => {
                            competenciaSelect.innerHTML +=
                                `<option value="${competencia.id}">${competencia.nombre}</option>`;
                        });
                    })
                    .catch(error => {
                        console.error('Error al cargar competencias:', error);
                    });
            } else {
                competenciaSelect.innerHTML = '<option value="">Seleccione una competencia</option>';
            }
        });
    }

    // Inicialización de Select2 si jQuery está disponible
    if (typeof $ !== 'undefined') {
        $(document).ready(function() {
            // Inicializar Select2 para competencias
            $('#competencia-select').select2({
                placeholder: "Escriba para buscar o seleccione competencias",
                tags: true,
                tokenSeparators: [',', ' '],
                allowClear: true,
                width: '100%'
            });

            $('#capacidad-select').select2({
                placeholder: "Capacidades relacionadas",
                allowClear: true,
                width: '100%'
            });

            $('#desempeno-select').select2({
                placeholder: "Desempeños relacionados",
                allowClear: true,
                width: '100%'
            });

            // Cargar capacidades al seleccionar competencias
            $('#competencia-select').on('change', function() {
                const competenciasSeleccionadas = $(this).val();
                const capacidadSelect = $('#capacidad-select');
                const desempenoSelect = $('#desempeno-select');

                // Limpiar siempre antes de recargar
                capacidadSelect.empty().trigger('change');
                desempenoSelect.empty().trigger('change');

                if (!competenciasSeleccionadas || competenciasSeleccionadas.length === 0) {
                    return;
                }

                // Crear un Set para evitar duplicados
                const capacidadesCargadas = new Set();
                const desempenosCargados = new Set();

                // Recorre todas las competencias seleccionadas
                competenciasSeleccionadas.forEach(function(competenciaId) {
                    // Cargar capacidades relacionadas
                    fetch(`/competencias/${competenciaId}/capacidades`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(function(capacidad) {
                                if (!capacidadesCargadas.has(capacidad.id)) {
                                    capacidadesCargadas.add(capacidad.id);
                                    capacidadSelect.append(new Option(capacidad.nombre, capacidad.id));
                                }
                            });
                            capacidadSelect.trigger('change');
                        })
                        .catch(error => {
                            console.error('Error al cargar capacidades:', error);
                        });

                    // Cargar desempeños relacionados
                    $.ajax({
                        url: '/desempenos/por-competencia-y-grado',
                        method: 'POST',
                        data: {
                            competencia_id: competenciaId,
                            grado: '{{ auth()->user()->usuario_aulas->first()?->aula->grado ?? "" }}',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            if (data.error) {
                                console.error(data.error);
                                return;
                            }

                            data.forEach(function(desempeno) {
                                if (!desempenosCargados.has(desempeno.id)) {
                                    desempenosCargados.add(desempeno.id);
                                    desempenoSelect.append(new Option(desempeno.descripcion, desempeno.id));
                                }
                            });

                            desempenoSelect.trigger('change');
                        },
                        error: function(error) {
                            console.error('Error al cargar desempeños:', error);
                        }
                    });
                });
            });

            // Evento al limpiar competencias manualmente
            $('#competencia-select').on('select2:clear', function() {
                $('#capacidad-select').empty().trigger('change');
                $('#desempeno-select').empty().trigger('change');
            });
        });
    }

    // Si ya hay un curso seleccionado, cargar sus competencias al cargar la página
    @if (isset($curso_id) && $curso_id)
        const cursoSelectElement = document.getElementById('curso-select');
        if (cursoSelectElement) {
            cursoSelectElement.dispatchEvent(new Event('change'));
        }
    @endif
});
</script>