<header>

    {{--Navegacion--}}
    <div class="navbar-fixed">
        <nav class="teal darken-1">

            <!-- Dropdown Usuarios -->
            <ul id="dropdownUser" class="dropdown-content">
                <li><a href="{!! route('admin.facturas.excel') !!}" class="waves-effect waves-teal">Facturación</a></li>
                <li class="divider"></li>
                <li><a href="{!! route('admin.user.profile') !!}" class="waves-effect waves-teal">Perfil</a></li>
                <li class="divider"></li>
                <li><a href="{{url('/logout')}}" class="waves-effect waves-teal">Logout</a></li>
            </ul>

            <!-- Dropdown Inscripciones -->
            <ul id="dropdownInsc" class="dropdown-content">
                <li><a href="{!! route('admin.inscripcions.index') !!}" class="waves-effect waves-teal">Inscripciones</a></li>
                <li class="divider"></li>
                @if (Entrust::can('create_inscripcion'))
                <li><a href="{!! route('admin.inscripcions.create') !!}" class="waves-effect waves-teal">Nueva</a></li>
                <li class="divider"></li>
                @endif
                <li><a href="{!! route('admin.alumnos.index') !!}" class="waves-effect waves-teal">Alumnos</a></li>
                <li class="divider"></li>
                <li><a href="{!! route('admin.representantes.index') !!}" class="waves-effect waves-teal">Representantes</a></li>
            </ul>

            <!-- Dropdown Programacion -->
            <ul id="dropdownProg" class="dropdown-content">
                @role(['planner','administrator'])
                <li><a href="{!! route('admin.modulos.index') !!}" class="waves-effect waves-teal">Modulos</a></li>
                <li class="divider"></li>
                <li><a href="{!! route('admin.programs.index') !!}" class="waves-effect waves-teal">Programa</a></li>
                <li class="divider"></li>
                @endrole
                <li><a href="{!! route('admin.calendars.index') !!}" class="waves-effect waves-teal">Cursos</a></li>
                <li class="divider"></li>

            </ul>

            <!-- Dropdown Ajustes -->
            <ul id="dropdownConfig" class="dropdown-content">
                @if(Auth::user()->hasRole(['planner','administrator']))
                    {{--@role(['planner,administrator'])--}}
                <li><a href="{!! route('admin.escenarios.index') !!}" class="waves-effect waves-teal">Escenarios</a></li>
                <li><a href="{!! route('admin.disciplinas.index') !!}" class="waves-effect waves-teal">Disciplinas</a></li>
                <li><a href="{!! route('admin.horarios.index') !!}" class="waves-effect waves-teal">Horarios</a></li>
                <li><a href="{!! route('admin.dias.index') !!}" class="waves-effect waves-teal">Días</a></li>
                <li><a href="{!! route('admin.encuestas.index') !!}" class="waves-effect waves-teal">Encuestas</a></li>
                <li><a href="{!! route('admin.transportes.index') !!}" class="waves-effect waves-teal">Transportes</a></li>
                <li><a href="{!! route('admin.fpagos.index') !!}" class="waves-effect waves-teal">Formas Pago</a></li>
                @endif
                @role('administrator')
                <li class="divider"></li>
                <li><a href="{!! route('admin.users.index') !!}" class="waves-effect waves-teal">Usuarios</a></li>
                <li><a href="{!! route('admin.roles.index') !!}" class="waves-effect waves-teal">Roles</a></li>
                <li><a href="{!! route('admin.permissions.index') !!}" class="waves-effect waves-teal">Permisos</a></li>
                {{--<li><a href="{!! route('persons.import') !!}" class="waves-effect waves-teal">Imp Personas</a></li>--}}
                @endrole


            </ul>
            <!-- Dropdown Reportes-->
            <ul id="dropdownReportes" class="dropdown-content">
                <li><a href="{{route('admin.facturas.index')}}" class="waves-effect waves-teal">Comprobantes</a></li>
                <li class="divider"></li>
                <li><a href="{{route('admin.pagos.cuadre')}}" class="waves-effect waves-teal">Cuadre</a></li>
                <li class="divider"></li>
                <li><a href="{{route('admin.reports.excel')}}" class="waves-effect waves-teal">Reporte General</a></li>
            </ul>

            <div class="nav-wrapper">
                {{--Logo--}}
                <img src="{{asset('img/camp/fdg-footer.png')}}" alt="logo" class="responsive-img right" style="height: 100%">
                {{--Button hamburger in moviles--}}
                <a href="#" data-activates="slide-out" class="button-collapse fixed"><i class="fa fa-navicon"></i></a>

                <ul class="left hide-on-med-and-down">

                    {{--<li class="active"><a href="#!" class="waves-effect waves-light"><i class="fa fa-1x fa-home left"></i>Inicio</a></li>--}}
                    {{--<li><a href="#!" class="waves-effect waves-light"><i class="fa fa-envelope left"></i>Contacto</a></li>--}}
                    <li>
                        <a href="{!! route('admin.inscripcions.reservas')!!}" class="waves-effect waves-light"><i class="fa fa-bell-o left"></i>Reservas<span class="badge red-text"  data-badge-caption="">{{ Session::has('reservas') ?  Session::get('reservas') : ''}}</span>
                        </a>
                    </li>

                    {{--<li><a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">repeat</i>Prueba</a></li>--}}
                    <!-- Dropdown Inscripciones -->
                    <li><a class="dropdown-button waves-effect waves-light" href="#!" data-beloworigin="true" data-hover="true" data-constrainwidth="false" data-activates="dropdownInsc">Inscripciones<i
                                    class="fa fa-pencil left"></i><i class="fa fa-sort-down right"></i></a></li>
                    <!-- Dropdown Programacion -->
                    <li><a class="dropdown-button waves-effect waves-light" href="#!" data-beloworigin="true" data-hover="true" data-constrainwidth="false" data-activates="dropdownProg">Programación<i
                                    class="fa fa-calendar left"></i><i class="fa fa-sort-down right"></i></a></li>
                    <!-- Dropdown Reportes -->
                    <li><a class="dropdown-button waves-effect waves-light" href="#!" data-beloworigin="true" data-hover="true" data-constrainwidth="false" data-activates="dropdownReportes">Reportes<i
                                    class="fa fa-bar-chart-o left"></i><i class="fa fa-sort-down right"></i></a></li>
                    <!-- Dropdown Ajustes -->
                    @if (Entrust::hasRole(['administrator', 'planner']))
                    <li><a class="dropdown-button waves-effect waves-light" href="#!" data-beloworigin="true" data-hover="true" data-constrainwidth="false" data-activates="dropdownConfig">Ajustes<i
                                    class="fa fa-gears left"></i><i class="fa fa-sort-down right"></i></a></li>
                    @endif
                    <!-- Dropdown Usuarios -->
                    <li><a class="dropdown-button waves-effect waves-light" href="#!" data-beloworigin="true" data-hover="true" data-constrainwidth="false" data-activates="dropdownUser">{{Auth::user()->first_name}}<i
                                    class="fa fa-user left"></i><i class="fa fa-sort-down right"></i></a></li>
                </ul>

                {{--SIDE BAR--}}
                <ul id="slide-out" class="side-nav teal lighten-1">

                    <li class="active"><a href="#!" class="waves-effect waves-light"><i class="fa fa-2x fa-home"></i></a></li>
                    {{--<li><a href="#!" class="waves-effect waves-red"><i class="fa fa-2x fa-envelope"></i></a></li>--}}
                    <li>
                        <a href="{!! route('admin.inscripcions.reservas')!!}" class="waves-effect waves-red"><i class="fa fa-2x fa-bell-o"></i>Reservas<span class="badge red-text"  data-badge-caption="">{{ Session::has('reservas') ?  Session::get('reservas') : ''}}</span>
                        </a>
                    </li>

                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li>
                                <a class="collapsible-header waves-effect waves-red">Inscripciones
                                    <i class="fa fa-pencil"></i></a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li><a href="{!! route('admin.inscripcions.index') !!}" class="waves-effect waves-teal">Inscripciones</a></li>
                                        <li class="divider"></li>
                                        @if (Entrust::can('create_inscripcion'))
                                        <li><a href="{!! route('admin.inscripcions.create') !!}" class="waves-effect waves-teal">Nueva</a></li>
                                        <li class="divider"></li>
                                        @endif
                                        <li><a href="{!! route('admin.alumnos.index') !!}" class="waves-effect waves-teal">Alumnos</a></li>
                                        <li class="divider"></li>
                                        <li><a href="{!! route('admin.representantes.index') !!}" class="waves-effect waves-teal">Representantes</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a class="collapsible-header waves-effect waves-red">Programación
                                    <i class="fa fa-calendar left"></i></a>
                                <div class="collapsible-body">
                                    <ul>
                                        @role(['planner','administrator'])
                                        <li><a href=" {!! route('admin.modulos.index') !!}" class="waves-effect waves-teal">Modulos</a></li>
                                        <li class="divider"></li>
                                        <li><a href=" {!! route('admin.programs.index') !!}" class="waves-effect waves-teal">Programa</a></li>
                                        <li class="divider"></li>
                                        @endrole
                                        <li><a href="{!! route('admin.calendars.index') !!}" class="waves-effect waves-teal">Cursos</a></li>
                                    </ul>
                                </div>
                            </li>

                           <li>
                            <a class="collapsible-header waves-effect waves-red">Reportes
                                <i class="fa fa-bar-chart-o left"></i></a>
                            <div class="collapsible-body">
                                <ul>
                                    <li><a href="{{route('admin.facturas.index')}}" class="waves-effect waves-teal">Comprobantes</a></li>
                                    <li class="divider"></li>
                                    <li><a href="{{route('admin.pagos.cuadre')}}" class="waves-effect waves-teal">Cuadre</a></li>
                                    <li><a href="{{route('admin.reports.excel')}}" class="waves-effect waves-teal">Reporte General</a></li>
                                </ul>
                            </div>
                            </li>

                            <li>
                                @if (Entrust::hasRole(['administrator', 'planner']))
                                    <a class="collapsible-header waves-effect waves-red">Ajustes
                                        <i class="fa fa-gears"></i>
                                    </a>
                                @endif
                                <div class="collapsible-body">
                                    <ul>
                                        @if(Auth::user()->hasRole(['planner','administrator']))
                                            <li><a href="#!" class="waves-effect waves-teal">Escenarios</a></li>
                                            <li class="divider"></li>
                                            <li><a href="#!" class="waves-effect waves-teal">Disciplinas</a></li>
                                            <li class="divider"></li>
                                            <li><a href="#!" class="waves-effect waves-teal">Horarios</a></li>
                                            <li class="divider"></li>
                                            <li><a href="#!" class="waves-effect waves-teal">Días</a></li>
                                            <li class="divider"></li>
                                            <li><a href="#!" class="waves-effect waves-teal">Encuestas</a></li>
                                            <li class="divider"></li>
                                            <li><a href="#!" class="waves-effect waves-teal">Transportes</a></li>
                                            <li class="divider"></li>
                                            <li><a href="#!" class="waves-effect waves-teal">Formas Pago</a></li>
                                        @endif
                                        @role('administrator')
                                        <li><a href="#!" class="waves-effect waves-teal">Usuarios</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#!" class="waves-effect waves-teal">Roles</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#!" class="waves-effect waves-teal">Permisos</a></li>
                                        @endrole
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a class="collapsible-header waves-effect waves-red">Usuarios
                                    <i class="fa fa-user"></i></a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li><a href="{!! route('admin.facturas.excel') !!}" class="waves-effect waves-teal">Facturación</a></li>
                                        <li><a href="{!! route('admin.user.profile') !!}" class="waves-effect waves-teal">Perfil</a></li>
                                        <li class="divider"></li>
                                        <li><a href="{{url('/logout')}}" class="waves-effect waves-teal">Logout</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
                {{--/.Side Bar--}}
            </div>
        </nav>
    </div>
    {{--/.Navegacion--}}


</header>