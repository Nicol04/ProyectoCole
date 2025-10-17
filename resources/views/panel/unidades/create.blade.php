<!doctype html>
<html lang="es">

<head>
    @include('panel.includes.head')
</head>

<body>
    <div class="preloader"></div>
    @if (auth()->check())
        @php
            $roleId = auth()->user()->roles->first()?->id;
        @endphp

        @if ($roleId == 3)
            @include('panel.includes.menu_estudiante')
        @elseif($roleId == 2)
            @include('panel.includes.menu_docente')
        @endif
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Por favor corrige los siguientes errores:</strong>
            <ul class="mt-2 mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="image-breadcrumb style-two"></div>

    <!--Text breadcrumb area start-->
    <section class="text-bread-crumb d-flex align-items-center">

        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-5">
                    <h2>Creación de unidades</h2>
                </div>
            </div>
        </div>
    </section>
    <!--Text breadcrumb area start-->
    <!-- INICIO DE CREACION DE UNIDADES -->
    <section class="middle-button-area py-4">
        <div class="container-fluid">
            <div class="container">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="font-green mb-3">Datos Generales de la Unidad</h4>

                        <!-- Contenedor para mensajes de error -->
                        <div id="error-container"></div>

                        <form action="{{ route('unidades.store') }}" method="POST">
                            @csrf
                            <!-- Nombre de la unidad -->
                            <div class="mb-3">
                                <label class="form-label">Nombre de la Unidad <span class="text-danger">*</span></label>
                                <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}"
                                    required maxlength="255" placeholder="Ingrese el nombre de la unidad">
                            </div>

                            <!-- Fechas -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Fecha de inicio <span class="text-danger">*</span></label>
                                    <input type="date" name="fecha_inicio" class="form-control"
                                        value="{{ old('fecha_inicio') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Fecha de fin <span class="text-danger">*</span></label>
                                    <input type="date" name="fecha_fin" class="form-control"
                                        value="{{ old('fecha_fin') }}" required>
                                </div>
                            </div>

                            <!-- Grado -->
                            <div class="mb-3">
                                <label class="form-label">Grado</label>
                                <input type="text" class="form-control" value="{{ $grado }}" readonly>
                                <input type="hidden" name="grado" value="{{ $grado }}">
                            </div>


                            <!-- Profesores responsables -->
                            <div class="form-group mb-3">
                                <label for="docentes">Docentes responsables <span class="text-danger">*</span></label>
                                <select id="docentes" name="profesores_responsables[]" multiple class="form-control" required>
                                    @foreach ($docentes as $id => $nombre)
                                        <option value="{{ $id }}">{{ $nombre }}</option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Seleccione al menos un docente responsable</small>
                            </div>


                            <!-- Situación significativa -->
                            <div class="mb-3">
                                <label class="form-label">Situación significativa <span class="text-danger">*</span></label>
                                <textarea name="situacion_significativa" rows="4" class="form-control" required 
                                    placeholder="Describe la situación significativa que motiva esta unidad (mínimo 10 caracteres)">{{ old('situacion_significativa') }}</textarea>
                                <small class="form-text text-muted">Mínimo 10 caracteres</small>
                            </div>

                            <!-- Productos esperados -->
                            <div class="mb-3">
                                <label class="form-label">Productos esperados <span class="text-danger">*</span></label>
                                <textarea name="productos" rows="3" class="form-control" required 
                                    placeholder="Describe los productos que se esperan obtener (mínimo 10 caracteres)">{{ old('productos') }}</textarea>
                                <small class="form-text text-muted">Mínimo 10 caracteres</small>
                            </div>

                            <!-- Contenido curricular dinámico -->
                            <div class="card mt-4 border-success">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0 text-success">
                                        <i class="fas fa-book me-2"></i>Contenido Curricular <span class="text-danger">*</span>
                                    </h5>
                                    <small class="text-muted">Debe agregar al menos un curso con sus competencias</small>
                                </div>
                                <div class="card-body">
                                    @include('components.contenido-curricular', [
                                        'cursos' => $cursos ?? collect(),
                                    ])
                                </div>
                            </div>
                            
                            <!-- Contenido de enfoques dinámico -->
                            <div class="mt-4">
                                <div class="alert alert-warning">
                                    <strong><i class="fas fa-exclamation-triangle"></i> Importante:</strong>
                                    Los enfoques transversales son <strong>obligatorios</strong>. Debe agregar al menos un enfoque con sus valores y actitudes correspondientes.
                                </div>
                                @include('components.enfoques')
                            </div>

                            <!-- Materiales y Recursos -->
                            <div class="card mt-4 border-info">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0 text-info">
                                        <i class="fas fa-tools icon-spacing"></i>Materiales y Recursos
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Materiales básicos -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Materiales básicos a utilizar en la unidad <span class="text-danger">*</span></label>
                                            <textarea name="materiales_basicos" rows="4" class="form-control" required
                                                placeholder="Ejemplo: Cartulinas, marcadores, papel bond, témperas, etc.">{{ old('materiales_basicos') }}</textarea>
                                            <small class="form-text text-muted">
                                                Describe los materiales físicos necesarios para desarrollar la unidad (mínimo 5 caracteres).
                                            </small>
                                        </div>

                                        <!-- Recursos -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Recursos a utilizar en la unidad <span class="text-danger">*</span></label>
                                            <textarea name="recursos" rows="4" class="form-control" required
                                                placeholder="Ejemplo: Aula virtual, videos educativos, material impreso, pizarra digital, etc.">{{ old('recursos') }}</textarea>
                                            <small class="form-text text-muted">
                                                Especifica los recursos tecnológicos, digitales o pedagógicos a utilizar (mínimo 5 caracteres).
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Botón -->
                            <div class="alert alert-info mt-4">
                                <strong><i class="fas fa-info-circle"></i> Información importante:</strong>
                                <ul class="mb-0 mt-2">
                                    <li>Los campos marcados con <span class="text-danger">*</span> son obligatorios</li>
                                    <li><strong>Contenido Curricular:</strong> Debe agregar al menos un curso con sus competencias correspondientes</li>
                                    <li><strong>Enfoques Transversales:</strong> Son obligatorios. Debe agregar al menos un enfoque con sus valores y actitudes</li>
                                    <li>Todos los campos de texto deben tener contenido válido con la longitud mínima requerida</li>
                                </ul>
                            </div>
                            
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save me-2"></i>Guardar Unidad
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- FIN DE CREACION DE UNIDADES -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Verificar que no se ejecute múltiples veces
            if (window.formValidationLoaded) {
                return;
            }
            window.formValidationLoaded = true;

            $('#docentes').select2({
                placeholder: "Seleccione docentes responsables",
                width: '100%',
                allowClear: true,
            });

            // Validación del formulario antes del envío
            $('form').off('submit').on('submit', function(e) {
                const errores = [];

                // Eliminar alertas previas
                $('.alert-danger').remove();

                // Validar nombre
                const nombre = $('[name="nombre"]').val().trim();
                if (!nombre) {
                    errores.push('El nombre de la unidad es obligatorio.');
                }

                // Validar fechas
                const fechaInicio = $('[name="fecha_inicio"]').val();
                const fechaFin = $('[name="fecha_fin"]').val();
                if (!fechaInicio) {
                    errores.push('La fecha de inicio es obligatoria.');
                }
                if (!fechaFin) {
                    errores.push('La fecha de fin es obligatoria.');
                }
                if (fechaInicio && fechaFin && new Date(fechaFin) < new Date(fechaInicio)) {
                    errores.push('La fecha de fin debe ser igual o posterior a la fecha de inicio.');
                }

                // Validar profesores responsables
                const profesores = $('#docentes').val();
                if (!profesores || profesores.length === 0) {
                    errores.push('Debe seleccionar al menos un profesor responsable.');
                }

                // Validar situación significativa
                const situacion = $('[name="situacion_significativa"]').val().trim();
                if (!situacion) {
                    errores.push('La situación significativa es obligatoria.');
                } else if (situacion.length < 10) {
                    errores.push('La situación significativa debe tener al menos 10 caracteres.');
                }

                // Validar productos
                const productos = $('[name="productos"]').val().trim();
                if (!productos) {
                    errores.push('Los productos esperados son obligatorios.');
                } else if (productos.length < 10) {
                    errores.push('Los productos esperados deben tener al menos 10 caracteres.');
                }

                // Validar contenido curricular (cursos)
                const cursos = $('#cursos-container .curso-block').length;
                if (cursos === 0) {
                    errores.push('Debe agregar al menos un curso.');
                } else {
                    // Validar que cada curso tenga al menos una competencia
                    $('#cursos-container .curso-block').each(function() {
                        const cursoSelect = $(this).find('.curso-select').val();
                        const competencias = $(this).find('.competencias-list .competencia-block').length;
                        
                        if (!cursoSelect) {
                            errores.push('Todos los cursos deben estar seleccionados.');
                            return false;
                        }
                        
                        if (competencias === 0) {
                            errores.push('Cada curso debe tener al menos una competencia. Las competencias son obligatorias.');
                            return false;
                        }
                        
                        // Validar que cada competencia esté completa
                        $(this).find('.competencia-block').each(function() {
                            const competencia = $(this).find('.competencia-select').val();
                            if (!competencia) {
                                errores.push('Todas las competencias deben estar seleccionadas.');
                                return false;
                            }
                        });
                    });
                }

                // Validar materiales básicos
                const materiales = $('[name="materiales_basicos"]').val().trim();
                if (!materiales) {
                    errores.push('Los materiales básicos son obligatorios.');
                } else if (materiales.length < 5) {
                    errores.push('Los materiales básicos deben tener al menos 5 caracteres.');
                }

                // Validar recursos
                const recursos = $('[name="recursos"]').val().trim();
                if (!recursos) {
                    errores.push('Los recursos son obligatorios.');
                } else if (recursos.length < 5) {
                    errores.push('Los recursos deben tener al menos 5 caracteres.');
                }

                // Validar enfoques transversales (obligatorios)
                const enfoques = $('.enfoque-card').length;
                if (enfoques === 0) {
                    errores.push('Debe agregar al menos un enfoque transversal. Los enfoques transversales son obligatorios.');
                } else {
                    $('.enfoque-card').each(function() {
                        const enfoqueSelect = $(this).find('select[name*="enfoque_id"]').val();
                        const valores = $(this).find('.valor-box').length;
                        
                        if (!enfoqueSelect) {
                            errores.push('Todos los enfoques transversales deben estar seleccionados.');
                            return false;
                        }
                        
                        if (valores === 0) {
                            errores.push('Cada enfoque seleccionado debe tener al menos un valor.');
                            return false;
                        }
                        
                        // Validar que cada valor tenga selección y actitud
                        $(this).find('.valor-box').each(function() {
                            const valor = $(this).find('.valor-select').val();
                            const actitud = $(this).find('.actitud-textarea').val().trim();
                            
                            if (!valor) {
                                errores.push('Todos los valores de los enfoques deben estar seleccionados.');
                                return false;
                            }
                            if (!actitud) {
                                errores.push('Todas las actitudes de los enfoques son obligatorias.');
                                return false;
                            }
                        });
                    });
                }

                // Mostrar errores si los hay
                if (errores.length > 0) {
                    e.preventDefault();
                    
                    // Limpiar contenedor de errores
                    $('#error-container').empty();
                    
                    let mensajeError = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                    mensajeError += '<strong><i class="fas fa-exclamation-triangle"></i> Por favor corrija los siguientes errores:</strong>';
                    mensajeError += '<ul class="mt-2 mb-0">';
                    errores.forEach(function(error) {
                        mensajeError += '<li>' + error + '</li>';
                    });
                    mensajeError += '</ul>';
                    mensajeError += '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    mensajeError += '</div>';
                    
                    // Mostrar mensaje en el contenedor específico
                    $('#error-container').html(mensajeError);
                    
                    // Scroll hacia arriba para ver el error
                    $('html, body').animate({
                        scrollTop: $('#error-container').offset().top - 100
                    }, 500);
                    
                    return false;
                }

                // Limpiar errores si todo está bien
                $('#error-container').empty();
                
                // Si no hay errores, mostrar loading
                $(this).find('button[type="submit"]').html('<i class="fas fa-spinner fa-spin"></i> Guardando...').prop('disabled', true);
            });

        });
    </script>

    @include('panel.includes.footer3')
    @include('panel.includes.footer')
</body>

</html>
