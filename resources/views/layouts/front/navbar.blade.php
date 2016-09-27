<nav class="navbar navbar-dark navbar-fixed-top scrolling-navbar">

    <!-- Collapse button-->
    <button class="navbar-toggler hidden-sm-up" type="button" data-toggle="collapse" data-target="#collapseEx">
        <i class="fa fa-bars"></i>
    </button>

    <div class="container">

        <!--Collapse content-->
        <div class="collapse navbar-toggleable-xs" id="collapseEx">
            <!--Navbar Brand-->
            <a class="navbar-brand" href="http://www.fedeguayas.com.ec" target="_blank">FDG</a>
            <!--Links-->
            <ul class="nav navbar-nav smooth-scroll">
                <li class="nav-item active">
                    <a class="nav-link" href="/home">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#disciplinas">Disciplinas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#beneficios">Beneficios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#examples-of-use">Ejemplos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#opiniones">Testimonios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#precios">Precios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contacto">Contacto</a>
                </li>

                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li class="nav-item"><a class="nav-link" href="{{ url('/login') }}">Login</a></li>
                    {{--<li class="nav-item"><a class="nav-link" href="{{ url('/register') }}">Register</a></li>--}}
                @else
                    <li class="nav-item dropdown">
                        <!-- Split button -->
                        <div class="btn-group">
                            {{--<button type="button" class="btn btn-sm info-color-dark"><i class="fa fa-user left"></i> {{ Auth::user()->first_name }}</button>--}}
                            {{--<button type="button" class="btn info-color-dark btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
                                {{--<span class="caret"></span>--}}
                                {{--<span class="sr-only">Toggle Dropdown</span>--}}
                            <button class="btn unique-color dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-user left"></i> {{ Auth::user()->first_name }}
                            </button>
                            </button>
                            <ul class="dropdown-menu unique-color">
                                <li class="st-mdb"><a class="dropdown-item " href="#">Perfil</a></li>
                                <li class="st-mdb"><a class="dropdown-item" href="#">Inscripciones</a></li>
                                <li class="st-mdb"><a class="dropdown-item" href="#">Comentar</a></li>
                                <div class="dropdown-divider"></div>
                                <li class="st-mdb"><a class="nav-link text-danger dropdown-item" href="{{ url('/logout') }}"><i class="fa fa-sign-out"></i>Salir</a></li>
                            </ul>
                        </div>
                    </li>
                @endif
            </ul>

        </div>
        <!--/.Collapse content-->

    </div>

</nav>