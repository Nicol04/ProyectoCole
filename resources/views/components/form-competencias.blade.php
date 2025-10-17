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
    // ✅ MEJORADO: Evento para cambio de curso
    const cursoSelect = document.getElementById('curso-select');
    if (cursoSelect) {
        cursoSelect.addEventListener('change', function() {
            const cursoId = this.value;
            const competenciaSelect = document.getElementById('competencia-select');

            // Limpiar competencias
            if (typeof $ !== 'undefined') {
                $('#competencia-select').empty().trigger('change');
                $('#capacidad-select').empty().trigger('change');
                $('#desempeno-select').empty().trigger('change');
            }

            if (cursoId) {
                fetch(`/cursos/${cursoId}/competencias`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Competencias cargadas:', data);
                        if (typeof $ !== 'undefined') {
                            data.forEach(competencia => {
                                $('#competencia-select').append(new Option(competencia.nombre, competencia.id));
                            });
                            $('#competencia-select').trigger('change');
                        }
                    })
                    .catch(error => {
                        console.error('Error al cargar competencias:', error);
                    });
            }
        });
    }

    // Inicialización de Select2 si jQuery está disponible
    if (typeof $ !== 'undefined') {
        $(document).ready(function() {
            // Inicializar Select2
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

            // ✅ MEJORADO: Cargar capacidades y desempeños al seleccionar competencias
            $('#competencia-select').on('change', function() {
                const competenciasSeleccionadas = $(this).val();
                const capacidadSelect = $('#capacidad-select');
                const desempenoSelect = $('#desempeno-select');

                console.log('Competencias seleccionadas:', competenciasSeleccionadas);

                // Limpiar antes de cargar
                capacidadSelect.empty().trigger('change');
                desempenoSelect.empty().trigger('change');

                if (!competenciasSeleccionadas || competenciasSeleccionadas.length === 0) {
                    return;
                }

                // Crear Sets para evitar duplicados
                const capacidadesCargadas = new Set();
                const desempenosCargados = new Set();

                // Recorrer todas las competencias seleccionadas
                competenciasSeleccionadas.forEach(function(competenciaId, index) {
                    // 1️⃣ Cargar capacidades
                    fetch(`/competencias/${competenciaId}/capacidades`)
                        .then(response => response.json())
                        .then(data => {
                            console.log(`Capacidades para competencia ${competenciaId}:`, data);
                            data.forEach(function(capacidad) {
                                if (!capacidadesCargadas.has(capacidad.id)) {
                                    capacidadesCargadas.add(capacidad.id);
                                    capacidadSelect.append(new Option(capacidad.nombre, capacidad.id));
                                }
                            });
                            if (index === 0) capacidadSelect.trigger('change');
                        })
                        .catch(error => {
                            console.error('Error al cargar capacidades:', error);
                        });

                    // 2️⃣ Cargar desempeños
                    $.ajax({
                        url: '/desempenos/por-competencia-y-grado',
                        method: 'POST',
                        data: {
                            competencia_id: [competenciaId], // ✅ Enviar como array
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            console.log(`Desempeños para competencia ${competenciaId}:`, data);
                            
                            if (data.error) {
                                console.error('Error del servidor:', data.error);
                                return;
                            }

                            if (Array.isArray(data)) {
                                data.forEach(function(desempeno) {
                                    if (!desempenosCargados.has(desempeno.id)) {
                                        desempenosCargados.add(desempeno.id);
                                        desempenoSelect.append(new Option(desempeno.descripcion, desempeno.id));
                                    }
                                });
                                
                                // Trigger change solo en el último elemento
                                if (index === competenciasSeleccionadas.length - 1) {
                                    desempenoSelect.trigger('change');
                                }
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error AJAX al cargar desempeños:', {
                                competencia_id: competenciaId,
                                status: status,
                                error: error,
                                response: xhr.responseText
                            });
                            
                            if (xhr.responseJSON && xhr.responseJSON.error) {
                                console.error('Error específico:', xhr.responseJSON.error);
                            }
                        }
                    });
                });
            });

            // Limpiar al quitar selección
            $('#competencia-select').on('select2:clear', function() {
                $('#capacidad-select').empty().trigger('change');
                $('#desempeno-select').empty().trigger('change');
            });
        });
    }

    // ✅ Si hay curso preseleccionado, cargar competencias
    @if (isset($curso_id) && $curso_id)
        setTimeout(() => {
            const cursoSelectElement = document.getElementById('curso-select');
            if (cursoSelectElement && cursoSelectElement.value) {
                cursoSelectElement.dispatchEvent(new Event('change'));
            }
        }, 500);
    @endif
});
</script>