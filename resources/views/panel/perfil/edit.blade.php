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

    <form action="{{ route('user.avatar.update', auth()->user()->id) }}" method="POST">
    @csrf
    <div class="row" id="avatar-selection">
        @foreach ($avatars as $avatar)
            <!--single product-->
            <div class="col-md-4 mb-4">
                <div class="sin-product text-center">
                    <div class="pro-image position-relative">
                        <label class="avatar-label">
                            <input type="radio" name="avatar_id" value="{{ $avatar->id }}" class="d-none" required>
                            <a href="#">
                                <img src="{{ asset('storage/' . $avatar->path) }}" alt="{{ $avatar->name }}" style="width: 100%; height: 250px; object-fit: cover;" class="avatar-img">
                            </a>
                        </label>
                        <div class="wishlist">
                            <a href="#"><i class="fa fa-heart-o"></i></a>
                        </div>
                    </div>
                    <h6 class="mt-2">{{ $avatar->name }}</h6>
                </div>
            </div>
        @endforeach
    </div>

</form>


    @include('panel.includes.footer3')
    @include('panel.includes.footer')
</body>

</html>
