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
    <div class="image-breadcrumb nu-bc"> </div>

    <!--Send message area start-->

    <section class="send-message-area">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <h1 class="area-heading font-w style-three">Hola docente! Aca podrás escribir algún comunicado para
                        tu aula {{ $aula->grado }} - {{ $aula->seccion }} </h1>
                </div>

                <div class="col-md-8 col-lg-9 col-xl-6">
                    <form action="{{ route('comunicados.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <textarea name="mensaje" class="form-control" rows="5" placeholder="Escribe tu comunicado aquí...">{{ old('mensaje') }}</textarea>
                            </div>
                        </div>
                        <br>
                        <div class="col-md-12">
                            <button type="submit" class="kids-care-btn bg-sky f14">
                                <i class="fa fa-check"></i> Enviar Comunicado
                            </button>
                        </div>
                    </form>

                    {{-- Mensajes de éxito o error --}}
                    @if (session('success'))
                        <div class="alert alert-success mt-3">{{ session('success') }}</div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger mt-3">{{ session('error') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger mt-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </section>
    <!--Send message area end-->
    <script>
        const textarea = document.querySelector('textarea[name="mensaje"]');
        const maxWords = 200;
        const warning = document.createElement('small');
        warning.style.display = 'block';
        warning.style.marginTop = '8px';
        warning.style.color = '#ff0000';
        textarea.parentElement.appendChild(warning);

        textarea.addEventListener('input', () => {
            const words = textarea.value.trim().split(/\s+/).filter(w => w.length > 0);
            const count = words.length;

            if (count > maxWords) {
                warning.textContent = `Has superado el límite de 200 palabras. Actualmente: ${count}`;
            } else {
                warning.textContent = `Palabras: ${count}/200`;
            }
        });
    </script>

    <!--Countdown for upcoming event end-->
    @include('panel.includes.footer3')
    @include('panel.includes.footer')
</body>

</html>
