<!-- Logo -->
<a href="http://www.fedeguayas.com.ec" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>FDG</b></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>FDGuayas</b></span>
</a>
<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Navegacion</span>
    </a>
    <!-- Navbar Right Menu -->

    <!-- Right Side Of Navbar -->
    <ul class="nav navbar-nav navbar-right">
        <!-- Authentication Links -->
    </ul>
    <div class="navbar-custom-menu">
    </div>

    <!-- Right Side Of Navbar -->
    <ul class="nav navbar-nav navbar-right">
        <!-- Authentication Links -->
        @if (Auth::guest())
            <li><a href="{{ url('/login') }}">Login</a></li>
            {{--<li><a href="{{ url('/register') }}">Register</a></li>--}}
            @else
               <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    <small><i class="fa fa-circle text-success"></i></small>
                    {{ Auth::user()->nombre }} <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-panel">
                        <div class="pull-left image">
                            <img src="{{asset('dist/img/users/'.Auth::user()->avatar)}}" class="img-circle" alt="Imagen Usuarios">
                        </div>
                  </li>
                    <!-- Sidebar user panel -->
                    <li class="user-header">
                        {{--<p>--}}
                            {{--www.fedeguayas.com.ec - Federación Deportiva--}}
                            {{--<small>www.facebook.com/fedeguayas</small>--}}
                        <p>Inscripciones: {{Auth::user()->inscripciones->count()}}</p>
                        <p>Valor Total: {{'$'.sprintf("%'2d.00",Auth::user()->inscripciones->sum('costo'))}}</p>
                        </p>
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        {{--<div class="pull-left">--}}
                            {{--<a href="{{ route('runner.profile.edit',[Auth::user()->id]) }}" class="btn btn-default btn-sm" >--}}
                                {{--<span class="glyphicon glyphicon-user" aria-hidden="true">Perfil</span></a>--}}
                        {{--</div>--}}
                        <div class="pull-right">
                            <a href="#" class="btn btn-default">-X-</a>
                            <a href="{{ url('/logout') }}" class="btn"><i class="fa fa-btn fa-sign-out"></i>Cerrar</a>
                        </div>
                    </li>

                </ul>
            </li>
        @endif
    </ul>
</nav>