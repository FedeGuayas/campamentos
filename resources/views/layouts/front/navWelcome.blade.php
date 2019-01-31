<div class="navbar-fixed">
    <nav>

        <!-- Dropdown Menu  Control-->
        <ul id="dropdownMenu" class="dropdown-content">
            {{--<li><a href="#!" class="waves-effect waves-teal">Perfil </a></li>--}}
            @if(Entrust::hasRole(['administrator','planner','signup','supervisor','invited']) )
                <li><a href="{{route('admin.index')}}" class="waves-effect waves-teal">Administración</a></li>
            @endif
            <div class="divider"></div>
            <li><a href="{{ url('/logout') }}" class="waves-effect waves-teal"><i class="fa fa-sign-out"></i>Salir</a>
            </li>
        </ul>

        <!-- Dropdown Otros Menus Control... -->

        {{--<nav class="teal" role="navigation">--}}

        {{--Contenedor del menu de navegacion--}}
        <div class="nav-wrapper teal darken-1">

            {{--Button hamburger activa la barra lateral en moviles para poner el menu de navegacion--}}
            <a href="#" data-activates="slide-out" class="button-collapse fixed"><i class="material-icons">menu</i></a>

            {{--Logo--}}
            <a id="logo-container" href="{{url('/')}}" class="brand-logo hide-on-med-and-down">
                <img src="{{asset('img/camp/fdg-footer.png')}}" alt="logo" style="max-height: 65px; width: auto;">
            </a>


            {{--barra de navegacion--}}
            <ul class="right hide-on-med-and-down show-on-large">
                <li>
                    {!! Form::open(['route'=>'curso-search', 'method'=>'GET', 'target'=>'_blank']) !!}
                        <div class="input-field">
                            <input id="termino" type="search" name="termino" required placeholder="Buscar cursos" autocomplete="off">
                            <label class="label-icon" for="search"><i class="material-icons">search</i></label>
                            <i class="material-icons">close</i>
                        </div>
                    {!! Form::close() !!}
                </li>
                <li><a href="{{route('online.preinscripcion')}}" class="waves-effect waves-teal">Inscripción</a></li>
                <li><a href="#disciplinas" class="waves-effect waves-teal">Disciplinas</a></li>
                {{--<li><a href="#beneficios" class="waves-effect waves-teal">Beneficios</a></li>--}}
                <li><a href="#contacto" class="waves-effect waves-teal">Contáctenos</a></li>
                @if(Auth::guest())
                    <li><a href="{{url('/login')}}">Login</a></li>
            @endif
            @if (Auth::check())
                <!-- Dropdown Menu Disparador -->
                    <li>
                        <a class="dropdown-button waves-effect waves-light" href="#!" data-beloworigin="true"
                           data-hover="true" data-constrainwidth="false"
                           data-activates="dropdownMenu">{{ Auth::user()->first_name }}<i class="material-icons right">arrow_drop_down</i><i
                                    class="fa fa-user left"></i>
                        </a>
                    </li>
            @endif
            <!--Otros Dropdown Menu Disparador -->
            </ul>{{--Fin barra de navegacion--}}

            {{--Barra Lateral para moviles--}}
            <ul id="slide-out" class="side-nav teal lighten-1">

                <li><a href="{{route('online.preinscripcion')}}" class="waves-effect waves-teal">Inscripción</a></li>
                <li><a href="#disciplinas" class="waves-effect waves-teal">Disciplinas</a></li>
                {{--<li><a href="#beneficios" class="waves-effect waves-teal">Beneficios</a></li>--}}
                <li><a href="#contacto" class="waves-effect waves-teal">Contáctenos</a></li>

                @if(Auth::guest())
                    <li><a href="{{url('/login')}}">Login</a></li>
                @endif

                <li class="no-padding">
                    <ul class="collapsible collapsible-accordion">
                        @if (Auth::check())
                            <li>{{--Menu Acordion --}}
                                <a class="collapsible-header waves-effect waves-red">{{ Auth::user()->first_name }}<i
                                            class="material-icons right">arrow_drop_down</i><i
                                            class="fa fa-user left"></i></a>
                                <div class="collapsible-body">
                                    <ul>
                                        {{--<li><a href="#" class="waves-effect waves-teal">Perfil </a></li>--}}
                                        @if(Entrust::hasRole(['administrator','planner','signup','supervisor','invited']) )
                                            <li><a href="{{route('admin.index')}}" class="waves-effect waves-teal">Administración</a>
                                            </li>
                                            <li class="divider"></li>
                                        @endif
                                        <li><a href="{{ url('/logout') }}" class="waves-effect waves-teal"><i
                                                        class="fa fa-sign-out"></i>Salir</a></li>
                                    </ul>
                                </div>
                            </li>{{--Fin Menu Acordion--}}
                        @endif
                        {{--Otros Menu Acordion --}}
                    </ul>
                </li>

            </ul>{{-- Fin Barra Lateral--}}

        </div>{{--Barra de navegacion--}}
    </nav>{{--</nav>--}}
</div>
