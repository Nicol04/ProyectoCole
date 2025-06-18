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

    <div class="image-breadcrumb style-two"></div>
    <!--Shop area start-->
    <section class="shop-area-wrapper">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-9">
                    <div class="shop-sorting">
                        <div class="sort-by">
                            <h2>RECURSOS 3D</h2>
                        </div>
                        <ul class="nav grid-list-button" role="tablist">
                            <li role="presentation"><a class="active" href="#home" aria-controls="home" role="tab"
                                    data-toggle="tab"><i class="fa fa-th"></i></a></li>
                            <li role="presentation"><a href="#profile" aria-controls="profile" role="tab"
                                    data-toggle="tab"><i class="fa fa-th-list"></i></a></li>
                        </ul>
                    </div>

                    <div class="shop-product-area tab-content">
                        <div role="tabpanel" class="tab-pane fade show active" id="home">
                            <div class="row">
                                @if ($recursos->isEmpty())
                                    <div class="col-12">
                                        <p class="text-center">No hay recursos disponibles para este curso.</p>
                                    </div>
                                @else
                                    @foreach ($recursos as $recurso)
                                        <div class="col-sm-6 col-md-6 col-xl-4">
                                            <div class="sin-product">

                                                <div class="pro-image">
                                                    <img src="{{ $recurso->imagen_preview ? asset('storage/' . $recurso->imagen_preview) : asset('img/product/p-5.png') }}"
                                                        alt="">
                                                    <div class="wishlist"><a href="#"><i
                                                                class="fa fa-heart-o"></i></a></div>
                                                    <div class="compare"><a
                                                            href="#">{{ $recurso->curso->curso }}</a></div>
                                                </div>
                                                <div class="pro-bottom">
                                                    <a class="pro-title">{{ $recurso->nombre }}</a>
                                                    <!-- Aquí muestra el nombre del recurso -->
                                                    <a href="{{ route('recursos.show', $recurso->id) }}"
                                                        class="add-to-cart">Visualizar</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif


                            </div>

                        </div>
                        <div role="tabpanel" class="tab-pane fade in" id="profile">
                            <div class="row">
                                <div class="col-md-12">
                                    @if ($recursos->isEmpty())
                                        <div class="col-12">
                                            <p class="text-center">No hay recursos disponibles para este curso.</p>
                                        </div>
                                    @else
                                        @foreach ($recursos as $recurso)
                                            <div class="row no-gutters list-product">
                                                <div class="col-md-4 col-xl-3">
                                                    <div class="list-pro-img">
                                                        <img src="{{ $recurso->imagen_preview ? asset('storage/' . $recurso->imagen_preview) : asset('img/product/p-5.png') }}"
                                                            alt="">
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-xl-9">
                                                    <div class="pro-bottom">
                                                        <a href="#" class="pro-title">{{ $recurso->nombre }}</a>
                                                        <p class="pro-price">{{ $recurso->curso->curso }}</p>
                                                        <p>{{ $recurso->descripcion }}</p>
                                                        <a href="{{ route('recursos.show', $recurso->id) }}"
                                                            class="add-to-cart">Visualizar</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Shop sidebar area start-->
                <div class="col-md-10 col-lg-4 col-xl-3">
                    <div class="shop-search-box">
                        <form method="GET" action="{{ route('recursos.index') }}">
                            <div class="input-group" id="search">
                                <input name="buscar" class="form-control" placeholder="Buscar por nombre..."
                                    type="text" value="{{ request('buscar') }}">
                                <button class="btn btn-default button-search" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!--sort by age-->
                    <div class="sort-area-sin">
                        <h5>Filtrar por curso</h5>
                        <ul class="sort-by-age">
                            <li class="{{ !isset($cursoId) ? 'checked' : '' }}">
                                <a href="{{ route('recursos.index', request()->except('curso')) }}">
                                    <i class="fa fa-check-circle"></i>Todos
                                </a>
                            </li>
                            @foreach ($cursos as $curso)
                                <li class="{{ isset($cursoId) && $cursoId == $curso->id ? 'checked' : '' }}">
                                    <a
                                        href="{{ route('recursos.index', array_merge(request()->all(), ['curso' => $curso->id])) }}">
                                        <i class="fa fa-circle-o"></i>{{ $curso->curso }}
                                        <span class="bgc-orange">{{ $curso->recursos_count }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!--sort by age-->
                    <div class="sort-area-sin">
                        <h5>Filtrar por categoría</h5>
                        <ul class="sort-by-age">
                            <li class="{{ !isset($categoriaId) ? 'checked' : '' }}">
                                <a href="{{ route('recursos.index') }}">
                                    <i class="fa fa-check-circle"></i>Todos
                                </a>
                            </li>
                            @foreach ($categorias as $categoria)
                                <li
                                    class="{{ isset($categoriaId) && $categoriaId == $categoria->id ? 'checked' : '' }}">
                                    <a href="{{ route('recursos.index', ['categoria' => $categoria->id]) }}">
                                        <i class="fa fa-circle-o"></i>{{ $categoria->nombre }}
                                        <span class="bgc-orange">{{ $categoria->recursos_count }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <!--Shop sidebar area end-->
                <div class="col-12 d-flex justify-content-center mt-4">
                    {{ $recursos->links() }}
                </div>
            </div>

        </div>
    </section>
    <!--Shop area end-->

    @include('panel.includes.footer3')
    @include('panel.includes.footer')
</body>

</html>
