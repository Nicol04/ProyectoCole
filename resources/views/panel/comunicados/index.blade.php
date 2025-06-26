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
    <!--Breadcrumb area start-->

    <div class="text-bread-crumb d-flex align-items-center style-six">
        <div class="container-fluid">
            <div class="row">
                <h2>Comunicados</h2>
            </div>
        </div>
    </div>
    <!--Comunicads two area start-->
    <section class="testtimonial-two-area">
        <div class="container text-center">
            <!-- Imagen de buzón -->
            <img src="{{ asset('assets/img/panel/bg/buzon.png') }}" alt="Buzón" class="mx-auto d-block mb-4"
                style="max-width: 1000px;">

            <!-- Filtros -->
            @if ($roleId == 3)
                <div class="btn-group mb-4" role="group" aria-label="Filtros">
                    <button class="btn filtro-btn active" data-filtro="todos">📬 Todos</button>
                    <button class="btn filtro-btn" data-filtro="no-vistos">📩 No vistos</button>
                    <button class="btn filtro-btn" data-filtro="vistos">✅ Leídos</button>
                </div>
            @endif

            <!-- Comunicados tipo cartas -->
            <div id="contenedorComunicados" class="row justify-content-center">
                @if ($roleId == 2)
                    <a href="{{ route('comunicados.create') }}" class="kids-care-btn bg-green mb-4">
                        <i class="fas fa-plus-circle"></i> Crear un comunicado
                    </a>
                @endif

                @foreach ($comunicados as $comunicado)
                    @php
                        $visto = $comunicado->vistosPor->contains($user->id);
                    @endphp
                    <div class="col-md-6 comunicado-item mb-4" data-estado="{{ $visto ? 'vistos' : 'no-vistos' }}">
                        <div class="card shadow border-0 carta-comunicado position-relative comunicado-click"
                            data-id="{{ $comunicado->id }}" data-user="{{ $roleId }}"
                            style="cursor: pointer; border-left: 5px solid {{ !$visto ? '#ffc107' : '#28a745' }}">




                            {{-- Icono de estado --}}
                            <div class="position-absolute top-0 end-0 p-2">
                                <i class="fas fa-envelope {{ $visto ? 'text-secondary' : 'text-warning' }} fs-4"></i>
                            </div>

                            <div class="card-body" style="background-color: #fffdf7;">
                                <h5 class="card-title" style="font-family: 'Grandstander'; color: #8373ce;">Comunicado
                                </h5>
                                <p class="card-text text-dark">{{ $comunicado->mensaje }}</p>
                                <small class="text-muted">{{ $comunicado->created_at->diffForHumans() }}</small>
                                @if (auth()->id() == $comunicado->user_id && $roleId == 2)
                                    <div class="mt-2 text-end">
                                        <a href="{{ route('comunicados.edit', $comunicado->id) }}"
                                            class="btn btn-sm btn-warning me-1 stop-click">
                                            Editar
                                        </a>

                                        <form action="{{ route('comunicados.destroy', $comunicado->id) }}"
                                            method="POST" class="d-inline eliminar-comunicado stop-click">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                        </form>
                                    </div>
                                @endif


                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    <!-- Modal -->
                    <div class="modal fade" id="comunicadoModal{{ $comunicado->id }}" tabindex="-1"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-xl">
                            <div class="modal-content modal-carta p-0 bg-transparent border-0">
                                <div class="modal-body text-center p-0">

                                    <img src="{{ asset('assets/img/panel/bg/carta.png') }}" class="img-carta mb-2"
                                        alt="Carta">

                                    <div class="contenido-mensaje mx-auto">
                                        <!-- Botón de cerrar flotante -->
                                        <button type="button" class="btn-close position-absolute top-0 end-0 m-3"
                                            data-bs-dismiss="modal" aria-label="Cerrar"></button>

                                        <p class="text-dark mt-4">{{ $comunicado->mensaje }}</p>

                                        <!-- Botón grande de cerrar abajo (opcional) -->
                                        <button type="button" class="btn btn-outline-danger mt-4"
                                            data-bs-dismiss="modal">×</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


            </div>
        </div>
        @endforeach
        </div> <!-- cierre de #contenedorComunicados -->
        <div class="col-12 d-flex justify-content-center mt-4">
            {{ $comunicados->links() }}
        </div>

        @if ($comunicados->isEmpty())
            <div class="col-12">
                <div class="alert alert-info">No hay comunicados por ahora.</div>
            </div>
        @endif
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.comunicado-click').forEach(card => {
                card.addEventListener('click', function(e) {
                    if (e.target.closest('.stop-click'))
                return; // Si se hace clic dentro de botones, no abrir modal

                    const id = this.dataset.id;
                    const userRole = this.dataset.user;

                    if (!id) return;

                    // Si el usuario es estudiante, marcar como visto
                    if (userRole == 3) {
                        marcarComoVisto(id, this);
                    }

                    const modalElement = document.getElementById('comunicadoModal' + id);
                    const modal = new bootstrap.Modal(modalElement);
                    modal.show();
                });
            });

            // Detener propagación en los botones internos
            document.querySelectorAll('.stop-click, .stop-click *').forEach(el => {
                el.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            });
            // Filtro de botones
            document.querySelectorAll('.filtro-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.querySelectorAll('.filtro-btn').forEach(b => b.classList.remove(
                        'active'));
                    this.classList.add('active');

                    const filtro = this.dataset.filtro;
                    document.querySelectorAll('.comunicado-item').forEach(item => {
                        const estado = item.dataset.estado;
                        item.style.display = (filtro === 'todos' || filtro === estado) ?
                            'block' : 'none';
                    });
                });
            });

            // Función para marcar como visto
            function marcarComoVisto(comunicadoId, elemento) {
                fetch(`/comunicados/${comunicadoId}/visto`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({})
                    })
                    .then(response => {
                        if (response.ok) {
                            const icon = elemento.querySelector('.fa-envelope');
                            if (icon) {
                                icon.classList.remove('text-warning');
                                icon.classList.add('text-secondary');
                            }
                            elemento.style.borderLeft = '5px solid #28a745';
                            elemento.closest('.comunicado-item').setAttribute('data-estado', 'vistos');
                        }
                    })
                    .catch(err => console.error('Error al marcar como visto:', err));
            }

            // Confirmación con SweetAlert al eliminar
            document.querySelectorAll('form.eliminar-comunicado').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: 'Este comunicado se eliminará permanentemente.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                });
            });
        });
    </script>

    <!--Countdown for upcoming event end-->
    @include('panel.includes.footer3')
    @include('panel.includes.footer')
</body>

</html>
