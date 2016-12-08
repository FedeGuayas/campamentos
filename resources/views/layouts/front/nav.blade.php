<div class="navbar-fixed">
    <!-- Dropdown Structure -->
    <ul id="dropdownUser" class="dropdown-content">
        <li><a href="">Hard </a></li>
        <li class="divider"></li>
        @if(Entrust::hasRole(['administrator','planner','signup','invited']) )
            <li><a href="{{route('admin.index')}}">Administración</a></li>
        @endif
        <div class="divider"></div>
        <li><a href="{{ url('/logout') }}"><i class="fa fa-sign-out"></i>Salir</a></li>
    </ul>

    <nav class="teal" role="navigation">
        <div class="nav-wrapper text-white container">
            <a id="logo-container" href="#" class="brand-logo"><img class="img-responsive" src="{{asset('../img/camp/fdg-footer.png')}}" alt="" style="max-height: 70px; width: auto;"></a>
            <ul class="right hide-on-med-and-down">
                <li class="active"><a class="nav-link" href="/home">Inicio<span class="sr-only">(current)</span><i class="material-icons left">home</i></a></li>
                <li><a href="#disciplinas">Disciplinas</a></li>
                <li><a href="#beneficios">Beneficios</a></li>
                <li><a href="#contacto">Contacto</a></li>
                @if(Auth::guest())
                    <li><a href="{{url('/login')}}">Login</a></li>
                @endif
                @if (Auth::check())
                <!-- Dropdown Trigger -->
                <li><a class="dropdown-button" href="#!" data-activates="dropdownUser">{{ Auth::user()->first_name }}<i class="material-icons right">arrow_drop_down</i><i class="fa fa-user left"></i></a></li>
                @endif
            </ul>

            {{--menu moviles --}}
            <ul id="nav-mobile" class="side-nav">
                <li><a href="#disciplinas">Disciplinas</a></li>
                <li><a href="#beneficios">Beneficios</a></li>
                <li><a href="#contacto">Contacto</a></li>
            </ul>
            <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
        </div>
    </nav>
</div>