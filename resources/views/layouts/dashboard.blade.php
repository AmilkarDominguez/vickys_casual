<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>CPanel</title>



    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toastr.css') }}">

    <!-- Iconos para tempusdominus -->
    <!-- Tempusdominus DateTime Picker-->
    <link rel="stylesheet" href="{{ asset('css/tempusdominus-bootstrap-4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">


    <link rel="stylesheet" href="{{ asset('css/fontello.css') }}">

    <link rel="shortcut icon" href="resources/vc.ico">
    <meta name="theme-color" content="#000000" />
    @yield('styles')
</head>

<body class="bg-secondary">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    CPanel
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @else


                        @if(Auth::user()->rol==='ADMIN')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAdministracion" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="icon-sliders"></i>Parametros
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownAdministracion">
                                <a class="dropdown-item" href="{{ route('Category.index') }}">Categorias</a>
                                <a class="dropdown-item" href="{{ route('Subcategory.index') }}">Sub categorias</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('Store.index') }}">Sucursales</a>
                                <a class="dropdown-item" href="{{ route('Product.index') }}">Productos</a>
                                {{-- <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('Subcategory.index') }}">Tiendas</a> --}}
                            </div>
                        </li>
                        @endif
                        @if(Auth::user()->rol==='ADMIN')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownReportes" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="icon-download"></i>Reportes
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownReportes">
                                <a class="dropdown-item" href="{{ route('Activity.index') }}">Consultas registradas</a>
                        </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <!--<a class="dropdown-item" href="!#">Cambiar contraseña</a>-->
                                <a class="dropdown-item"><i class="icon-user"></i>Tipo: {{ Auth::user()->rol }}</a>

                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Salir') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="p-2">
            @yield('content')
        </main>
    </div>
    <script src="{{ asset('js/assets/jquery-3.3.1.js') }}"></script>
    <script src="{{ asset('js/assets/popper.min.js') }}"></script>
    <script src="{{ asset('js/assets/bootstrap.min.js') }}"></script>
    <!--Alert-->
    <script src="{{ asset('js/assets/toastr.js') }}"></script>
    <!--Date Tables-->
    <script src="{{ asset('js/assets/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/assets/dataTables.bootstrap4.min.js') }}"></script>
    <!--Export Print DateTables-->
    <script src="{{ asset('js/assets/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/assets/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/assets/jszip.min.js') }}"></script>
    <script src="{{ asset('js/assets/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/assets/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/assets/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/assets/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/assets/buttons.colVis.min.js') }}"></script>
    <!--Tempusdominus DateTime Picker-->
    <script src="{{ asset('js/assets/moment.js') }}"></script>
    <script src="{{ asset('js/assets/es.js') }}"></script>
    <script src="{{ asset('js/assets/tempusdominus-bootstrap-4.js') }}"></script>

    <!--Read XLS-->
    <script src="{{ asset('js/assets/xlsx.core.min.js') }}"></script>

    <script src="{{ asset('js/scripts/main.js') }}"></script>

    <script>
        var user_id = {{Auth::user()->id}};
    </script>
    @yield('scripts')
</body>

</html>