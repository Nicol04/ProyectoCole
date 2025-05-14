<!doctype html>
<html lang="es">

<head>
    @include('panel.includes.head')
</head>

<body>
    <div class="preloader"></div>
    <div class="preloader"></div> <!-- carga -->
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
    <div class="text-bread-crumb d-flex align-items-center style-six blue">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2>Perfil</h2>
                    <div class="bread-crumb-line"><span><a href="/users/perfil">Perfil / </a></span>Editar avatar</div>
                </div>
            </div>
        </div>
    </div>
    <!--Breadcrumb area end-->

    <!--avatar area start-->
    <form action="{{ route('user.avatar.update', auth()->user()->id) }}" method="POST">
    @csrf
    <section class="kids-care-teachers-area">
        <div class="container-fluid custom-container">
            <div class="row">
                <div class="col-xl-12">
                    <h2 class="area-heading font-green">Selecciona tu avatar</h2>
                </div>
            </div>
            <div class="inner-container">
                <div class="row">
                    <div class="teacher-car-start owl-carousel owl-theme">
                        @foreach ($avatars as $avatar)
                            <div class="single-teacher item text-center">
                                <div class="teacher-img position-relative">
                                    <label class="avatar-label d-block">
                                        <input type="radio" name="avatar_id" value="{{ $avatar->id }}" class="d-none" required>
                                        <img src="{{ asset('storage/' . $avatar->path) }}" alt="{{ $avatar->name }}"
                                            class="avatar-img"
                                            style="width: 200px; height: 200px; border-radius: 50%; object-fit: cover; border: 4px solid transparent; cursor: pointer;">
                                    </label>
                                </div>
                                <div class="teacher-detail mt-2">
                                    <h4 class="mb-0">{{ $avatar->name }}</h4>
                                    <p class="text-muted">Haz clic para seleccionar</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Botones -->
                <div class="text-center mt-4 mb-5">
                    <button id="guardarAvatarBtn" type="submit" class="btn btn-primary me-3" disabled>
                        <i class="fa-solid fa-circle-check me-1"></i> Guardar avatar
                    </button>
                    <a href="{{ url('/users/perfil') }}" class="btn btn-secondary">
                        Cancelar
                    </a>
                </div>

            </div>
        </div>
        <div class="text-center my-3">
            <button class="btn btn-outline-primary me-2" id="prevBtn">
                <i class="fa fa-chevron-left me-1"></i> Anterior
            </button>
            <button class="btn btn-outline-primary" id="nextBtn">
                Siguiente <i class="fa fa-chevron-right ms-1"></i>
            </button>
        </div>

    </section>
</form>

    <!--AVATAR area end-->

    @include('panel.includes.footer3')
    @include('panel.includes.footer')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const radios = document.querySelectorAll('input[name="avatar_id"]');
        const guardarBtn = document.getElementById('guardarAvatarBtn');

        radios.forEach(radio => {
            radio.addEventListener('change', function () {
                if (this.checked) {
                    guardarBtn.disabled = false;
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function () {
        var owl = $(".teacher-car-start");

        owl.owlCarousel({
            items: 3,
            loop: false,
            nav: false,
            dots: false,
            margin: 10,
            onChanged: updateButtons
        });

        // Botón siguiente
        $("#nextBtn").click(function () {
            owl.trigger("next.owl.carousel");
        });

        // Botón anterior
        $("#prevBtn").click(function () {
            owl.trigger("prev.owl.carousel");
        });

        // Habilita o deshabilita los botones según la posición
        function updateButtons(event) {
            var totalItems = event.item.count;
            var visibleItems = event.page.size;
            var currentIndex = event.item.index;

            // Botón "Anterior"
            $("#prevBtn").prop("disabled", currentIndex === 0);

            // Botón "Siguiente"
            $("#nextBtn").prop("disabled", currentIndex + visibleItems >= totalItems);
        }

        // Llamar al inicio para desactivar el botón "Anterior"
        owl.trigger('refresh.owl.carousel');
    });
</script>

</body>

</html>
