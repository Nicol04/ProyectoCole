<!doctype html>
<html lang="es">

<head>
    @include('panel.includes.head')
</head>
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

<div class="image-breadcrumb style-two"></div>
@if ($roleId == 2)
    <!--Text breadcrumb area start-->
    <section class="text-bread-crumb d-flex align-items-center">

        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-5">
                    <h2>Promedio <span>( {{ $estudiante->persona->nombre }} {{ $estudiante->persona->apellido }}
                            )</span></h2>
                    <div class="bread-crumb-line"><a href=""><span>Estudiantes
                                /</span></a>{{ $estudiante->persona->nombre }} {{ $estudiante->persona->apellido }}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Text breadcrumb area start-->
@endif

@if ($roleId == 3)
    <div class="admission-process-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="area-heading font-per style-two">Hola {{ $estudiante->persona->nombre }}!</h1>
                    <p class="heading-para">Este es tu promedio en forma gráfica por curso</p>
                </div>
            </div>
        </div>
    </div>
    <!--Admission process area end-->
@endif

<!--Shop area start-->
<section class="shop-area-wrapper">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-9">
                <div class="shop-sorting">

                    <ul class="nav grid-list-button" role="tablist">
                        <li role="presentation"><a class="active" href="#home" aria-controls="home" role="tab"
                                data-toggle="tab"><i class="fa fa-th"></i></a></li>
                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab"
                                data-toggle="tab"><i class="fa fa-th-list"></i></a></li>
                    </ul>
                </div>

                <div class="shop-product-area tab-content">
                    <div role="tabpanel" class="tab-pane fade show active" id="home">
                        <div class="row justify-content-center">
                            @foreach ($promediosPorCurso as $curso => $datos)
                                <div class="col-md-4 mb-4 d-flex flex-column align-items-center">
                                    <h5 class="text-center">{{ $curso }}</h5>
                                    <canvas id="graficoCurso{{ $loop->index }}" width="200" height="200"></canvas>
                                    <div class="mt-2">
                                        @if ($datos['estado'] === 'Aprobado')
                                            <span class="badge bg-success">Aprobado</span>
                                        @elseif($datos['estado'] === 'Intermedio')
                                            <span class="badge bg-warning text-dark">Intermedio</span>
                                        @elseif($datos['estado'] === 'Desaprobado')
                                            <span class="badge bg-danger">Desaprobado</span>
                                        @else
                                            <span class="badge bg-secondary">Sin datos</span>
                                        @endif
                                        <span class="ms-2">{{ $datos['promedio_porcentaje'] }}%</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade in" id="profile">
                        <div class="row justify-content-center my-4">
        <div class="col-md-10">
            <canvas id="graficoBarras"></canvas>
        </div>
    </div>
                    </div>
                </div>
            </div>

            <!--Shop sidebar area start-->
            <div class="col-md-10 col-lg-4 col-xl-3">
                <!--sort by age-->
                <div class="sort-area-sin">
                    <h5>Leyenda de estados</h5>
                    <ul class="sort-by-age">
                        <li>
                            <span class="badge bg-success me-2" style="width:18px;height:18px;display:inline-block;"><i
                                    class="fa fa-circle"></i></span>
                            Aprobado <span class="bg-success text-white ms-2 px-2 rounded">≥ 70%</span>
                        </li>
                        <li>
                            <span class="badge bg-warning text-dark me-2"
                                style="width:18px;height:18px;display:inline-block;"><i class="fa fa-circle"></i></span>
                            Intermedio <span class="bg-warning text-dark ms-2 px-2 rounded">50% - 69%</span>
                        </li>
                        <li>
                            <span class="badge bg-danger me-2" style="width:18px;height:18px;display:inline-block;"><i
                                    class="fa fa-circle"></i></span>
                            Desaprobado <span class="bg-danger text-white ms-2 px-2 rounded">&lt; 50%</span>
                        </li>
                        <li>
                            <span class="badge bg-secondary me-2"
                                style="width:18px;height:18px;display:inline-block;"><i class="fa fa-circle"></i></span>
                            Sin datos
                        </li>
                    </ul>
                    
                </div>
                <div class="sort-area-sin">
    <h5>Escala de letras</h5>
    <ul class="sort-by-age">
        <li><strong>A</strong>: 70% a 100% (Excelente)</li>
        <li><strong>B</strong>: 50% a 69% (Medio)</li>
        <li><strong>C</strong>: 0% a 49% (Bajo)</li>
    </ul>
</div>
            </div>
            <!--Shop sidebar area end-->
        </div>
    </div>
</section>
<!--Shop area end-->
<div class="table-responsive my-4">
    <table class="table table-sm table-bordered text-center align-middle" style="max-width: 600px; margin: 0 auto;">
    <thead class="table-light">
        <tr>
            <th>Curso</th>
            <th>Promedio (%)</th>
            <th>Nota</th> <!-- NUEVA COLUMNA -->
            <th>Estado</th>
            <th>Evaluaciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($promediosPorCurso as $curso => $datos)
            <tr>
                <td>{{ $curso }}</td>
                <td>{{ $datos['promedio_porcentaje'] }}%</td>
                <td><strong>{{ $datos['letra'] }}</strong></td> <!-- MUESTRA LA LETRA -->
                <td>
                    @if($datos['estado'] === 'Aprobado')
                        <span class="badge bg-success">Aprobado</span>
                    @elseif($datos['estado'] === 'Intermedio')
                        <span class="badge bg-warning text-dark">Intermedio</span>
                    @elseif($datos['estado'] === 'Desaprobado')
                        <span class="badge bg-danger">Desaprobado</span>
                    @else
                        <span class="badge bg-secondary">Sin datos</span>
                    @endif
                </td>
                <td>{{ $datos['cantidad'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Datos para el gráfico de barras
    const labels = {!! json_encode(array_keys($promediosPorCurso)) !!};
    const porcentajes = {!! json_encode(array_column($promediosPorCurso, 'promedio_porcentaje')) !!};
    const colores = [
        @foreach ($promediosPorCurso as $datos)
            @if ($datos['estado'] === 'Aprobado')
                '#28a745',
            @elseif ($datos['estado'] === 'Intermedio')
                '#ffc107',
            @elseif ($datos['estado'] === 'Desaprobado')
                '#dc3545',
            @else
                '#6c757d',
            @endif
        @endforeach
    ];

    // Gráficos circulares por curso (estos sí se pueden inicializar directamente)
    @foreach ($promediosPorCurso as $curso => $datos)
        var ctx{{ $loop->index }} = document.getElementById('graficoCurso{{ $loop->index }}').getContext('2d');
        new Chart(ctx{{ $loop->index }}, {
            type: 'doughnut',
            data: {
                labels: ['Obtenido', 'Restante'],
                datasets: [{
                    data: [{{ $datos['promedio_porcentaje'] }}, {{ 100 - $datos['promedio_porcentaje'] }}],
                    backgroundColor: [
                        @if ($datos['estado'] === 'Aprobado')
                            '#28a745',
                        @elseif ($datos['estado'] === 'Intermedio')
                            '#ffc107',
                        @elseif ($datos['estado'] === 'Desaprobado')
                            '#dc3545',
                        @else
                            '#6c757d',
                        @endif
                        '#e9ecef'
                    ]
                }]
            },
            options: {
                cutout: '70%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.parsed + '%';
                            }
                        }
                    }
                }
            }
        });
    @endforeach

    // Gráfico de barras: solo inicializar cuando el tab esté visible
    let graficoBarras = null;
    function renderGraficoBarras() {
        const ctx = document.getElementById('graficoBarras').getContext('2d');
        if (graficoBarras) {
            graficoBarras.destroy();
        }
        graficoBarras = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Promedio (%)',
                    data: porcentajes,
                    backgroundColor: colores,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + '%';
                            }
                        }
                    }
                },
                scales: {
                    y: { beginAtZero: true, max: 100 }
                }
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Si el tab de barras está activo al cargar, dibuja el gráfico
        if(document.querySelector('#profile').classList.contains('active')) {
            renderGraficoBarras();
        }

        // Escucha el evento de mostrar el tab (Bootstrap 4)
        $('a[href="#profile"]').on('shown.bs.tab', function (e) {
            renderGraficoBarras();
        });
    });
</script>
@include('panel.includes.footer3')
@include('panel.includes.footer')

</body>

</html>
