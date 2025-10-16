{{-- Componente dinámico para contenido curricular --}}
<div id="contenido-curricular-container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="font-green mb-0">Contenido Curricular</h4>
        <button type="button" class="btn btn-success btn-sm" id="agregar-curso">
            <i class="fas fa-plus icon-spacing"></i>Agregar Curso
        </button>
    </div>

    {{-- Container para los bloques de cursos --}}
    <div id="cursos-container" class="mb-4">
        {{-- Aquí se agregarán dinámicamente los bloques de cursos --}}
    </div>
</div>

{{-- Template para un bloque de curso --}}
<template id="curso-template">
    <div class="curso-block card mb-4 border-success">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-success">
                <i class="fas fa-book icon-spacing"></i>Curso <span class="curso-numero"></span>
            </h5>
            <button type="button" class="btn btn-danger btn-sm eliminar-curso">
                <i class="fas fa-trash icon-spacing"></i>Eliminar
            </button>
        </div>
        <div class="card-body">
            {{-- Selector de curso --}}
            <div class="row mb-3">
                <div class="col-md-12">
                    <label class="form-label fw-bold">Seleccionar Curso</label>
                    <select name="contenido[cursos][INDEX][curso_id]" class="form-control curso-select" required>
                        <option value="">Seleccione un curso</option>
                        @if(isset($cursos))
                            @foreach ($cursos as $curso)
                                <option value="{{ $curso->id }}" data-nombre="{{ $curso->curso }}">{{ $curso->curso }}</option>
                            @endforeach
                        @endif
                    </select>
                    <input type="hidden" name="contenido[cursos][INDEX][nombre]" class="curso-nombre-hidden">
                </div>
            </div>

            {{-- Container para competencias --}}
            <div class="competencias-container">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="text-primary mb-0">
                        <i class="fas fa-brain icon-spacing"></i>Competencias
                    </h6>
                    <button type="button" class="btn btn-primary btn-sm agregar-competencia">
                        <i class="fas fa-plus icon-spacing"></i>Agregar Competencia
                    </button>
                </div>
                <div class="competencias-list">
                    {{-- Aquí se agregarán las competencias --}}
                </div>
            </div>
        </div>
    </div>
</template>

{{-- Estilos específicos para corregir conflictos con el CSS del proyecto --}}
<style>
/* Estilos específicos para el contenido curricular */
#contenido-curricular-container {
    width: 100% !important;
    max-width: 100% !important;
}

#cursos-container {
    width: 100% !important;
    display: block !important;
    overflow: visible !important;
}

.curso-block {
    width: 100% !important;
    max-width: 100% !important;
    display: block !important;
    height: auto !important;
    min-height: auto !important;
    overflow: visible !important;
    margin-bottom: 1.5rem !important;
    position: relative !important;
    clear: both !important;
}

.curso-block .card-body {
    width: 100% !important;
    max-width: 100% !important;
    padding: 1.25rem !important;
    overflow: visible !important;
    height: auto !important;
    min-height: auto !important;
}

.competencias-container,
.competencias-list {
    width: 100% !important;
    max-width: 100% !important;
    display: block !important;
    overflow: visible !important;
    height: auto !important;
    min-height: auto !important;
    clear: both !important;
}

.competencia-block {
    width: 100% !important;
    max-width: 100% !important;
    display: block !important;
    height: auto !important;
    min-height: auto !important;
    overflow: visible !important;
    margin-bottom: 1rem !important;
    position: relative !important;
    clear: both !important;
    float: none !important;
}

.competencia-block .row {
    width: 100% !important;
    margin: 0 !important;
    display: flex !important;
    flex-wrap: wrap !important;
}

.competencia-block .col-md-6,
.competencia-block .col-md-12 {
    width: 100% !important;
    max-width: 100% !important;
    flex: 0 0 100% !important;
    padding: 0.375rem !important;
    margin-bottom: 0.75rem !important;
}

@media (min-width: 768px) {
    .competencia-block .col-md-6 {
        flex: 0 0 48% !important;
        max-width: 48% !important;
        width: 48% !important;
        margin-right: 2% !important;
    }
    
    .competencia-block .col-md-6:nth-child(even) {
        margin-right: 0 !important;
    }
}

/* Select2 específico */
.select2-container {
    width: 100% !important;
    max-width: 100% !important;
    z-index: 9999 !important;
}

.select2-dropdown {
    z-index: 9999 !important;
}

.select2-container--default .select2-selection--multiple {
    min-height: 38px !important;
    border: 1px solid #ced4da !important;
    border-radius: 0.375rem !important;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #007bff !important;
    border: 1px solid #007bff !important;
    color: white !important;
    padding: 0 8px !important;
    border-radius: 3px !important;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    color: white !important;
    margin-right: 5px !important;
}

/* Estilos para selects normales */
.competencia-select,
.curso-select {
    height: 38px !important;
    padding: 6px 12px !important;
    font-size: 14px !important;
    line-height: 1.42857143 !important;
    border: 1px solid #ced4da !important;
    border-radius: 0.375rem !important;
    background-color: #fff !important;
    background-image: none !important;
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075) !important;
}

/* Formularios */
.form-control, .form-select {
    width: 100% !important;
    max-width: 100% !important;
    display: block !important;
}

/* Botones */
.btn {
    display: inline-block !important;
    white-space: nowrap !important;
}

/* Contenedores de Bootstrap */
.container, .container-fluid {
    overflow: visible !important;
}

/* Cards */
.card {
    overflow: visible !important;
    height: auto !important;
    min-height: auto !important;
}

/* Forzar visibilidad */
.d-flex {
    display: flex !important;
}

.justify-content-between {
    justify-content: space-between !important;
}

.align-items-center {
    align-items: center !important;
}

/* Márgenes específicos */
.mb-3 {
    margin-bottom: 1rem !important;
}

.mb-4 {
    margin-bottom: 1.5rem !important;
}

/* Corrige problemas de posicionamiento */
#contenido-curricular-container * {
    box-sizing: border-box !important;
}

/* Asegura que los templates no interfieran */
template {
    display: none !important;
}
</style>

{{-- Template para una competencia --}}
<template id="competencia-template">
    <div class="competencia-block border border-primary rounded p-3 mb-3 bg-light">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="text-primary mb-0">
                <i class="fas fa-lightbulb icon-spacing"></i>Competencia <span class="competencia-numero"></span>
            </h6>
            <button type="button" class="btn btn-outline-danger btn-sm eliminar-competencia">
                <i class="fas fa-times icon-spacing"></i>Eliminar
            </button>
        </div>

        <div class="row">
            {{-- Competencia --}}
            <div class="col-md-12 mb-3">
                <label class="form-label">Competencia</label>
                <select name="contenido[cursos][CURSO_INDEX][competencias][COMP_INDEX][competencia_id]" 
                        class="form-control competencia-select" required>
                    <option value="">Seleccione una competencia</option>
                </select>
                <input type="hidden" name="contenido[cursos][CURSO_INDEX][competencias][COMP_INDEX][nombre]" class="competencia-nombre-hidden">
            </div>

            {{-- Capacidades --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Capacidades</label>
                <select name="contenido[cursos][CURSO_INDEX][competencias][COMP_INDEX][capacidades][]" 
                        class="form-control capacidades-select" multiple>
                    <option value="">Seleccione capacidades</option>
                </select>
            </div>

            {{-- Desempeños --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Desempeños</label>
                <select name="contenido[cursos][CURSO_INDEX][competencias][COMP_INDEX][desempenos][]" 
                        class="form-control desempenos-select" multiple>
                    <option value="">Seleccione desempeños</option>
                </select>
            </div>

            {{-- Criterios --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Criterios de Evaluación</label>
                <textarea name="contenido[cursos][CURSO_INDEX][competencias][COMP_INDEX][criterios]" 
                          class="form-control" rows="3" 
                          placeholder="Describa los criterios de evaluación..."></textarea>
            </div>

            {{-- Evidencias --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Evidencias</label>
                <textarea name="contenido[cursos][CURSO_INDEX][competencias][COMP_INDEX][evidencias]" 
                          class="form-control" rows="3" 
                          placeholder="Describa las evidencias de aprendizaje..."></textarea>
            </div>

            {{-- Instrumentos --}}
            <div class="col-md-12 mb-3">
                <label class="form-label">Instrumentos de Evaluación</label>
                <select name="contenido[cursos][CURSO_INDEX][competencias][COMP_INDEX][instrumentos][]" 
                        class="form-control instrumentos-select" multiple>
                    <option value="Lista de cotejo">Lista de cotejo</option>
                    <option value="Rúbrica">Rúbrica</option>
                    <option value="Escala de valoración">Escala de valoración</option>
                    <option value="Registro anecdótico">Registro anecdótico</option>
                    <option value="Portafolio">Portafolio</option>
                    <option value="Observación directa">Observación directa</option>
                </select>
            </div>
        </div>
    </div>
</template>


<script>
document.addEventListener('DOMContentLoaded', function() {
    let cursoIndex = 0;
    const cursosContainer = document.getElementById('cursos-container');
    const cursoTemplate = document.getElementById('curso-template');
    const competenciaTemplate = document.getElementById('competencia-template');

    // Agregar curso
    document.getElementById('agregar-curso').addEventListener('click', function() {
        agregarCurso();
    });

    // --- AGREGAR CURSO ---
    function agregarCurso() {
        const cursoClone = cursoTemplate.content.cloneNode(true);
        const cursoBlock = cursoClone.querySelector('.curso-block');
        cursoBlock.dataset.cursoIndex = cursoIndex;
        cursoClone.querySelector('.curso-numero').textContent = cursoIndex + 1;

        // Reemplazar INDEX en nombres
        cursoClone.querySelectorAll('[name*="INDEX"]').forEach(input => {
            input.name = input.name.replace('INDEX', cursoIndex);
        });

        // Eventos del curso
        const eliminarBtn = cursoClone.querySelector('.eliminar-curso');
        eliminarBtn.addEventListener('click', function() {
            cursoBlock.remove();
            actualizarNumeracion();
        });
        const cursoSelect = cursoClone.querySelector('.curso-select');
        cursoSelect.addEventListener('change', function() {
            const nombreHidden = cursoBlock.querySelector('.curso-nombre-hidden');
            nombreHidden.value = this.options[this.selectedIndex].dataset.nombre || '';
            
            // Cargar competencias para todas las competencias existentes en este curso
            cargarCompetenciasCurso(this.value, cursoBlock);
            
            // Limpiar capacidades, desempeños y competencias de todas las competencias cuando cambia el curso
            cursoBlock.querySelectorAll('.competencia-select').forEach(select => {
                select.selectedIndex = 0; // Resetear a "Seleccione una competencia"
                const nombreHidden = cursoBlock.querySelector('.curso-nombre-hidden');
                if (nombreHidden) {
                    nombreHidden.value = '';
                }
            });
            
            cursoBlock.querySelectorAll('.capacidades-select').forEach(select => {
                $(select).empty().trigger('change');
            });
            
            cursoBlock.querySelectorAll('.desempenos-select').forEach(select => {
                $(select).empty().trigger('change');
            });
        });

        // Botón para agregar competencias
        cursoClone.querySelector('.agregar-competencia').addEventListener('click', function() {
            agregarCompetencia(cursoBlock);
        });

        cursosContainer.appendChild(cursoClone);

        // Solo inicializar Select2 para capacidades, desempeños e instrumentos (no para competencias ni cursos)
        inicializarSelect2Limitado(cursoBlock);
        
        // Forzar layout del nuevo curso
        forzarLayout(cursoBlock);

        cursoIndex++;
    }

    // --- AGREGAR COMPETENCIA ---
    function agregarCompetencia(cursoBlock) {
        const competenciaClone = competenciaTemplate.content.cloneNode(true);
        const competenciasList = cursoBlock.querySelector('.competencias-list');
        const cursoIdx = cursoBlock.dataset.cursoIndex;
        const competenciaIndex = competenciasList.children.length;

        // Actualizar índices y nombres
        competenciaClone.querySelector('.competencia-numero').textContent = competenciaIndex + 1;
        competenciaClone.querySelectorAll('[name*="CURSO_INDEX"]').forEach(input => {
            input.name = input.name.replace('CURSO_INDEX', cursoIdx).replace('COMP_INDEX', competenciaIndex);
        });

        const competenciaBlock = competenciaClone.querySelector('.competencia-block');

        // Eliminar competencia
        competenciaClone.querySelector('.eliminar-competencia').addEventListener('click', function() {
            competenciaBlock.remove();
            actualizarNumeracionCompetencias(cursoBlock);
        });

        // Cargar capacidades y desempeños
        const competenciaSelect = competenciaClone.querySelector('.competencia-select');
        competenciaSelect.addEventListener('change', function() {
            const nombreHidden = competenciaBlock.querySelector('.competencia-nombre-hidden');
            nombreHidden.value = this.options[this.selectedIndex].text || '';
            
            const capacidadSelect = $(competenciaBlock.querySelector('.capacidades-select'));
            const desempenoSelect = $(competenciaBlock.querySelector('.desempenos-select'));
            
            // Limpiar campos antes de cargar nuevos datos
            capacidadSelect.empty().trigger('change');
            desempenoSelect.empty().trigger('change');
            
            if (this.value) {
                // Cargar capacidades para la competencia seleccionada
                cargarCapacidades(this.value, competenciaBlock);
                // Cargar desempeños para la competencia seleccionada
                cargarDesempenosPorCompetencia(this.value, competenciaBlock);
            }
        });

        // Obtener el curso seleccionado y cargar sus competencias
        const cursoSelect = cursoBlock.querySelector('.curso-select');
        const cursoId = cursoSelect.value;
        
        if (cursoId) {
            // Cargar competencias disponibles para este curso
            cargarCompetenciasParaSelect(cursoId, competenciaSelect);
        }

        competenciasList.appendChild(competenciaClone);
        
        // Inicializar Select2 SOLO para los campos múltiples de esta competencia
        inicializarSelect2ParaCompetencia(competenciaBlock);
        
        // Agregar evento para limpiar campos cuando se elimine toda la selección de capacidades
        setTimeout(() => {
            const $capacidadSelect = $(competenciaBlock.querySelector('.capacidades-select'));
            const $desempenoSelect = $(competenciaBlock.querySelector('.desempenos-select'));
            
            // Evento para limpiar desempeños al limpiar capacidades
            $capacidadSelect.on('select2:clear', function() {
                $desempenoSelect.empty().trigger('change');
            });
            
        }, 200);
        
        // Forzar re-layout más agresivo
        setTimeout(() => {
            // Forzar recalculo de dimensiones
            cursoBlock.style.height = 'auto';
            cursoBlock.style.minHeight = 'auto';
            cursoBlock.style.overflow = 'visible';
            
            // Asegurar que el contenedor padre se expanda
            const competenciasContainer = cursoBlock.querySelector('.competencias-container');
            const competenciasList = cursoBlock.querySelector('.competencias-list');
            
            if (competenciasContainer) {
                competenciasContainer.style.height = 'auto';
                competenciasContainer.style.overflow = 'visible';
            }
            
            if (competenciasList) {
                competenciasList.style.height = 'auto';
                competenciasList.style.overflow = 'visible';
            }
            
            // Forzar un repaint
            cursoBlock.offsetHeight;
            
            // Trigger resize event para Select2
            $(window).trigger('resize');
        }, 150);
        
    }

    // --- CARGAR COMPETENCIAS POR CURSO ---
    function cargarCompetenciasCurso(cursoId, cursoBlock) {
        if (!cursoId) return;

        fetch(`/cursos/${cursoId}/competencias`)
            .then(response => response.json())
            .then(data => {
                cursoBlock.querySelectorAll('.competencia-select').forEach(select => {
                    select.innerHTML = '<option value="">Seleccione una competencia</option>';
                    data.forEach(c => {
                        select.innerHTML += `<option value="${c.id}">${c.nombre}</option>`;
                    });
                });
            })
            .catch(err => console.error('Error al cargar competencias:', err));
    }

    // --- CARGAR COMPETENCIAS PARA UN SELECT ESPECÍFICO ---
    function cargarCompetenciasParaSelect(cursoId, selectElement) {
        if (!cursoId || !selectElement) return;

        fetch(`/cursos/${cursoId}/competencias`)
            .then(response => response.json())
            .then(data => {
                selectElement.innerHTML = '<option value="">Seleccione una competencia</option>';
                data.forEach(c => {
                    selectElement.innerHTML += `<option value="${c.id}">${c.nombre}</option>`;
                });
            })
            .catch(err => console.error('Error al cargar competencias:', err));
    }

    // --- CARGAR CAPACIDADES POR COMPETENCIA ---
    function cargarCapacidades(competenciaId, competenciaBlock) {
        if (!competenciaId) return;

        fetch(`/competencias/${competenciaId}/capacidades`)
            .then(response => response.json())
            .then(data => {
                const select = competenciaBlock.querySelector('.capacidades-select');
                const $select = $(select);
                
                // Limpiar opciones
                $select.empty();
                
                // Agregar nuevas opciones
                data.forEach(cap => {
                    $select.append(new Option(cap.nombre, cap.id));
                });
                
                // Trigger change para Select2
                $select.trigger('change');
                
                // Agregar evento para limpiar desempeños cuando cambien las capacidades
                $select.off('change.capacidades').on('change.capacidades', function() {
                    const desempenoSelect = $(competenciaBlock.querySelector('.desempenos-select'));
                    const capacidadesSeleccionadas = $(this).val();
                    
                    // Limpiar desempeños
                    desempenoSelect.empty().trigger('change');
                    
                    if (capacidadesSeleccionadas && capacidadesSeleccionadas.length > 0) {
                        // Recargar desempeños basados en la competencia (no en capacidades específicas)
                        cargarDesempenosPorCompetencia(competenciaId, competenciaBlock);
                    }
                });
            })
            .catch(err => console.error('Error al cargar capacidades:', err));
    }

    // --- CARGAR DESEMPEÑOS POR COMPETENCIA Y GRADO ---
    function cargarDesempenosPorCompetencia(competenciaId, competenciaBlock) {
        if (!competenciaId) return;

        $.ajax({
            url: '/desempenos/por-competencia-y-grado',
            method: 'POST',
            data: {
                competencia_id: competenciaId,
                grado: '{{ auth()->user()->usuario_aulas->first()?->aula->grado ?? "" }}',
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                const select = competenciaBlock.querySelector('.desempenos-select');
                const $select = $(select);
                
                if (data.error) {
                    console.error(data.error);
                    return;
                }
                
                // Limpiar opciones
                $select.empty();
                
                // Agregar nuevas opciones
                data.forEach(desempeno => {
                    $select.append(new Option(desempeno.descripcion, desempeno.id));
                });
                
                // Trigger change para Select2
                $select.trigger('change');
            },
            error: function(err) {
                console.error('Error al cargar desempeños:', err);
            }
        });
    }

    // --- ACTUALIZAR NÚMEROS DE CURSOS ---
    function actualizarNumeracion() {
        const cursos = cursosContainer.querySelectorAll('.curso-block');
        cursos.forEach((curso, i) => {
            curso.dataset.cursoIndex = i;
            curso.querySelector('.curso-numero').textContent = i + 1;
        });
        cursoIndex = cursos.length;
    }

    // --- ACTUALIZAR NÚMEROS DE COMPETENCIAS ---
    function actualizarNumeracionCompetencias(cursoBlock) {
        const competencias = cursoBlock.querySelectorAll('.competencia-block');
        competencias.forEach((comp, i) => {
            comp.querySelector('.competencia-numero').textContent = i + 1;
        });
    }

    // --- FORZAR LAYOUT ---
    function forzarLayout(elemento) {
        setTimeout(() => {
            // Aplicar estilos de layout
            elemento.style.width = '100%';
            elemento.style.maxWidth = '100%';
            elemento.style.height = 'auto';
            elemento.style.overflow = 'visible';
            elemento.style.display = 'block';
            
            // Forzar recalculo
            elemento.offsetHeight;
            
            // Aplicar a elementos internos
            const cardBody = elemento.querySelector('.card-body');
            if (cardBody) {
                cardBody.style.width = '100%';
                cardBody.style.overflow = 'visible';
                cardBody.style.height = 'auto';
            }
            
            const competenciasContainer = elemento.querySelector('.competencias-container');
            if (competenciasContainer) {
                competenciasContainer.style.width = '100%';
                competenciasContainer.style.overflow = 'visible';
                competenciasContainer.style.height = 'auto';
            }
            
            const competenciasList = elemento.querySelector('.competencias-list');
            if (competenciasList) {
                competenciasList.style.width = '100%';
                competenciasList.style.overflow = 'visible';
                competenciasList.style.height = 'auto';
            }
        }, 50);
    }

    // --- INICIALIZAR SELECT2 PARA UNA COMPETENCIA ESPECÍFICA ---
    function inicializarSelect2ParaCompetencia(competenciaBlock) {
        setTimeout(() => {
            // Inicializar Select2 para capacidades
            $(competenciaBlock).find('.capacidades-select').each(function() {
                const $select = $(this);
                
                if ($select.hasClass('select2-hidden-accessible')) {
                    $select.select2('destroy');
                }
                
                $select.select2({
                    allowClear: true,
                    width: '100%',
                    placeholder: "Capacidades relacionadas",
                    dropdownParent: $(competenciaBlock)
                });
            });
            
            // Inicializar Select2 para desempeños
            $(competenciaBlock).find('.desempenos-select').each(function() {
                const $select = $(this);
                
                if ($select.hasClass('select2-hidden-accessible')) {
                    $select.select2('destroy');
                }
                
                $select.select2({
                    allowClear: true,
                    width: '100%',
                    placeholder: "Desempeños relacionados",
                    dropdownParent: $(competenciaBlock)
                });
            });
            
            // Inicializar Select2 para instrumentos
            $(competenciaBlock).find('.instrumentos-select').each(function() {
                const $select = $(this);
                
                if ($select.hasClass('select2-hidden-accessible')) {
                    $select.select2('destroy');
                }
                
                $select.select2({
                    allowClear: true,
                    width: '100%',
                    placeholder: "Seleccione instrumentos de evaluación",
                    dropdownParent: $(competenciaBlock)
                });
            });
            
        }, 100);
    }

    // --- INICIALIZAR SELECT2 LIMITADO (solo para múltiples) ---
    function inicializarSelect2Limitado(contexto) {
        setTimeout(() => {
            $(contexto).find('.capacidades-select, .desempenos-select, .instrumentos-select').each(function() {
                const $select = $(this);
                
                // Destruir Select2 existente si existe
                if ($select.hasClass('select2-hidden-accessible')) {
                    $select.select2('destroy');
                }
                
                let config = {
                    allowClear: true,
                    width: '100%',
                    placeholder: "Seleccione una o más opciones",
                    dropdownParent: $(contexto)
                };

                try {
                    $select.select2(config);
                    console.log('Select2 inicializado para:', $select.attr('class'));
                } catch (error) {
                    console.error('Error inicializando Select2:', error);
                }
            });
        }, 150);
    }

    // --- INICIALIZAR SELECT2 (función original mantenida por compatibilidad) ---
    function inicializarSelect2(contexto) {
        // Esperar un poco antes de inicializar Select2
        setTimeout(() => {
            $(contexto).find('select').each(function() {
                const $select = $(this);
                
                // Destruir Select2 existente si existe
                if ($select.hasClass('select2-hidden-accessible')) {
                    $select.select2('destroy');
                }
                
                // Configuración específica según el tipo de select
                let config = {
                    allowClear: true,
                    width: '100%',
                    dropdownAutoWidth: true,
                    containerCssClass: 'select2-container--custom',
                    dropdownCssClass: 'select2-dropdown--custom'
                };

                if ($select.hasClass('capacidades-select') || $select.hasClass('desempenos-select') || $select.hasClass('instrumentos-select')) {
                    config.placeholder = "Seleccione una o más opciones";
                } else if ($select.hasClass('competencia-select')) {
                    config.placeholder = "Seleccione una competencia";
                } else if ($select.hasClass('curso-select')) {
                    config.placeholder = "Seleccione un curso";
                }

                $select.select2(config);
            });
        }, 100);
    }


    // Curso inicial
    agregarCurso();
});
</script>