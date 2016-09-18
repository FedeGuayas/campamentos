<header>

    {{--Navegacion--}}
    <nav class="nav-wrapper navbar-fixed teal darken-4">

        <!-- Dropdown Usuarios -->
        <ul id="dropdownUser" class="dropdown-content">
            <li><a href="#!" class="waves-effect waves-teal">Perfil</a></li>
            <li class="divider"></li>
            <li><a href="#!" class="waves-effect waves-teal">Logout</a></li>
        </ul>

        <!-- Dropdown Inscripciones -->
        <ul id="dropdownInsc" class="dropdown-content">
            <li><a href="#!" class="waves-effect waves-teal">Listar</a></li>
            <li class="divider"></li>
            <li><a href="#!" class="waves-effect waves-teal">Nueva</a></li>
            <li class="divider"></li>
            <li><a href="#!" class="waves-effect waves-teal">Editar</a></li>
            <li class="divider"></li>
            <li><a href="#!" class="waves-effect waves-teal">Alumnos</a></li>
            <li class="divider"></li>
            <li><a href="#!" class="waves-effect waves-teal">Representantes</a></li>
        </ul>
        <!-- Dropdown Ajustes -->
        <ul id="dropdownConfig" class="dropdown-content">
            <li><a href="#!" class="waves-effect waves-teal">Representantes</a></li>
            <li class="divider"></li>
            <li><a href="#!" class="waves-effect waves-teal">Alumnos</a></li>
            <li class="divider" ></li>
            <li><a href="#!" class="waves-effect waves-teal">Escenarios</a></li>
            <li class="divider" ></li>
            <li><a href="#!" class="waves-effect waves-teal">Disciplinas</a></li>
            <li class="divider"></li>
            <li><a href="#!" class="waves-effect waves-teal">Horarios</a></li>
            <li class="divider"></li>
            <li><a href="#!" class="waves-effect waves-teal">Modulos</a></li>
            <li class="divider"></li>
            <li><a href="#!" class="waves-effect waves-teal">Cupos</a></li>
        </ul>
        <!-- Dropdown Reportes-->
        <ul id="dropdownReportes" class="dropdown-content">
            <li><a href="#!" class="waves-effect waves-teal">Facturacion</a></li>
            <li class="divider"></li>
            <li><a href="#!" class="waves-effect waves-teal">Cuadre</a></li>
            <li class="divider"></li>
            <li><a href="#!" class="waves-effect waves-teal">Reportes</a></li>
        </ul>


        {{--Logo--}}
        <img src="{{asset('img/camp/fdg-footer.png')}}" alt="logo" class="responsive-img" style="height: 100%">
        {{--Button hamburger in moviles--}}
        <a href="#" data-activates="slide-out" class="button-collapse right fixed"><i class="material-icons">menu</i></a>

        <ul class="right hide-on-med-and-down">

            <li class="active"><a href="#!" class="waves-effect waves-light"><i class="material-icons left">home</i>Home</a></li>
            <li><a href="#!" class="waves-effect waves-light"><i class="material-icons left">contact_mail</i>Contacto</a></li>
            <li><a href="#!" class="waves-effect waves-light"><i class="material-icons left">add_alert</i>Alertas<span class="new badge red">4</span></a></li>
            <a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">repeat</i></a>
            <!-- Dropdown Inscripciones -->
            <li><a class="dropdown-button waves-effect waves-light" href="#!" data-activates="dropdownInsc">Inscripciones<i class="material-icons left">mode_edit</i></a></li>
            <!-- Dropdown Reportes -->
            <li><a class="dropdown-button waves-effect waves-light" href="#!" data-activates="dropdownReportes">Reportes<i class="material-icons left">library_books</i></a></li>
            <!-- Dropdown Ajustes -->
            <li><a class="dropdown-button waves-effect waves-light" href="#!" data-activates="dropdownConfig">Ajustes<i class="material-icons left">settings</i></a></li>
            <!-- Dropdown Usuarios -->
            <li><a class="dropdown-button waves-effect waves-light" href="#!" data-activates="dropdownUser">Usuario<i class="material-icons right">arrow_drop_down</i><i class="material-icons left">person</i></a></li>

        </ul>

        {{--Side Bar--}}
        <ul id="slide-out" class="side-nav  teal darken-1">

            <li class="active"><a href="#!" class="waves-effect waves-red"><i class="material-icons left">home</i></a></li>
            <li><a href="#!" class="waves-effect waves-red"><i class="material-icons left">contact_mail</i></a></li>
            <li><a href="#!" class="waves-effect waves-red"><i class="material-icons left">add_alerts</i><span class="new badge red">4</span></a></li>
            <li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                    <li>
                        <a class="collapsible-header waves-effect waves-red">Inscripciones<i class="material-icons right">arrow_drop_down</i>
                            <i class="material-icons left">mode_edit</i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="#!" class="waves-effect waves-teal">Listar</a></li>
                                <li class="divider"></li>
                                <li><a href="#!" class="waves-effect waves-teal">Nueva</a></li>
                                <li class="divider"></li>
                                <li><a href="#!" class="waves-effect waves-teal">Editar</a></li>
                                <li class="divider"></li>
                                <li><a href="#!" class="waves-effect waves-teal">Alumnos</a></li>
                                <li class="divider"></li>
                                <li><a href="#!" class="waves-effect waves-teal">Representantes</a></li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a class="collapsible-header waves-effect waves-red" >Usuarios<i class="material-icons right">arrow_drop_down</i>
                            <i class="material-icons left">person</i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="#!" class="waves-effect waves-teal">Perfil</a></li>
                                <li class="divider"></li>
                                <li><a href="#!" class="waves-effect waves-teal">Logout</a></li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a class="collapsible-header waves-effect waves-red" >Ajustes<i class="material-icons right">arrow_drop_down</i>
                            <i class="material-icons left">settings</i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="#!" class="waves-effect waves-teal">Representantes</a></li>
                                <li class="divider"></li>
                                <li><a href="#!" class="waves-effect waves-teal">Alumnos</a></li>
                                <li class="divider" ></li>
                                <li><a href="#!" class="waves-effect waves-teal">Escenarios</a></li>
                                <li class="divider" ></li>
                                <li><a href="#!" class="waves-effect waves-teal">Disciplinas</a></li>
                                <li class="divider"></li>
                                <li><a href="#!" class="waves-effect waves-teal">Horarios</a></li>
                                <li class="divider"></li>
                                <li><a href="#!" class="waves-effect waves-teal">Modulos</a></li>
                                <li class="divider"></li>
                                <li><a href="#!" class="waves-effect waves-teal">Cupos</a></li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a class="collapsible-header waves-effect waves-red" >Reportes<i class="material-icons right">arrow_drop_down</i>
                            <i class="material-icons left">library_books</i></a>
                        <div class="collapsible-body">
                            <ul>
                                <li><a href="#!" class="waves-effect waves-teal">Facturacion</a></li>
                                <li class="divider"></li>
                                <li><a href="#!" class="waves-effect waves-teal">Cuadre</a></li>
                                <li class="divider"></li>
                                <li><a href="#!" class="waves-effect waves-teal">Reportes</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>

        {{--/.Side Bar--}}

    </nav>
    {{--/.Navegacion--}}

</header>