<div class="navbar-fixed">
    <nav class="teal darken-1" role="navigation">

        <!-- Dropdown Structure -->
        <ul id="dropdownUser" class="dropdown-content">
            <li><a href="{{ url('/logout') }}"><i class="fa fa-sign-out"></i>Salir</a></li>
        </ul>

        {{--Contenedor del menu de navegacion--}}
        <div class="nav-wrapper container">
            {{--Button hamburger activa la barra lateral en moviles para poner el menu de navegacion--}}
            <a href="#" data-activates="slide-out" class="button-collapse fixed"><i class="material-icons">menu</i></a>
            {{--<a href="#" data-activates="slide-out" class="button-collapse fixed"><i class="material-icons">menu</i></a>--}}

            {{--Logo--}}
            <a id="logo-container" href="#" class="brand-logo"><img class="img-responsive" src="{{asset('img/camp/fdg-footer.png')}}" alt="" style="max-height: 65px; width: auto;"></a>

            {{--barra de navegacion--}}
            <ul class="right hide-on-med-and-down">
                <li class="active"><a href="/" class="nav-link waves-effect waves-teal">Inicio<span class="sr-only">(current)</span><i class="material-icons left">home</i></a></li>
                <li><a href="#" class="waves-effect waves-teal">Cursos</a></li>
                <li><a href="#" class="waves-effect waves-teal">Contacto</a></li>
                <li><a href="/home" class="waves-effect waves-teal">Mis Datos</a></li>

                        <!-- Dropdown Trigger -->
                <li><a class="dropdown-button waves-effect waves-light" href="#!" data-beloworigin="true" data-hover="true" data-constrainwidth="false" data-activates="dropdownUser">{{ Auth::user()->first_name }}<i class="material-icons right">arrow_drop_down</i><i class="fa fa-user left"></i></a>
                </li>

            </ul>{{--Fin barra de navegacion--}}

            {{--Barra Lateral para moviles--}}
            {{--<ul id="slide-out" class="side-nav teal lighten-1">--}}
            <ul id="slide-out" class="side-nav teal lighten-1">
                <li class="active"><a href="/" class="waves-effect waves-teal">Inicio<span class="sr-only">(current)</span><i class="material-icons left">home</i></a></li>
                <li><a href="#" class="waves-effect waves-teal">Cursos</a></li>
                <li><a href="#" class="waves-effect waves-teal">Contacto</a></li>
                <li><a href="/home" class="waves-effect waves-teal">Mis Datos</a></li>

                <li class="no-padding">
                    <ul class="collapsible collapsible-accordion">

                        <li>{{--Menu Acordion Usuario--}}
                            <a class="collapsible-header waves-effect waves-teal">{{ Auth::user()->first_name }}<i class="material-icons right">arrow_drop_down</i><i class="fa fa-user left"></i></a>
                            <div class="collapsible-body">
                                <ul>
                                    <li><a href="{{ url('/logout') }}" class="waves-effect waves-teal"><i class="fa fa-sign-out"></i>Salir</a></li>
                                </ul>
                            </div>
                        </li>{{--Fin Menu Acordion Usuario--}}

                        {{--Otros Menu Acordion --}}

                    </ul>
                </li>

            </ul>

        </div>


    </nav>
</div>