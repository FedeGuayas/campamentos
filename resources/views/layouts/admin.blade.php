<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>FDGuayas | Campamentos Deportivos</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('bootstrap/css/font-awesome.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
    folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('dist/css/skins/_all-skins.min.css')}}">
    <link rel="apple-touch-icon" href="{{asset('img/apple-touch-icon.png')}}">
    <link rel="shortcut icon" href="{{asset('img/favicon.ico')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <header class="main-header">
       @include('layouts.header')
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="header"></li>
                <li class="treeview">
                    <a href="{{ url('/home') }}">
                        <i class="fa fa-home"></i>
                        <span>Home</span>
                        <i class="fa "></i>
                    </a>
                    {{--//solo mostrar si el usuario lof¿geado es administrador, rols_id=1--}}
                @if (Auth::user()->rols_id==1)
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-gears"></i>
                        <span>Configuraciones</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ url('/runner/circuitos') }}"><i class="fa fa-circle-o"></i>Circuitos</a>
                        <li><a href="{{ url('/runner/categorias') }}"><i class="fa fa-circle-o"></i>Categorias</a>
                        <li><a href="{{ url('/runner/escenarios') }}"><i class="fa fa-circle-o"></i>Escenarios</a>
                        <li><a href="{{ url('/runner/usuarios') }}"><i class="fa fa-circle-o"></i>Usuario</a>
                        <li><a href="{{ url('/runner/roles') }}"><i class="fa fa-circle-o"></i>Roles</a>
                        <li><a href="{{ url('/runner/deportes') }}"><i class="fa fa-circle-o"></i>Deportes</a>
                        <li><a href="{{ url('/runner/inscripciones') }}"><i class="fa fa-circle-o"></i>Exportar Exel</a>
                    </ul>
                </li>
                @endif
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-edit"></i>
                        <span>Inscripciones</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ url('/runner/personas') }}"><i class="fa fa-circle-o"></i>Runners</a></li>
                        <li><a href="{{ url('/runner/inscripciones/') }}"><i class="fa fa-circle-o"></i>Listado Inscripciones</a>
                        </li>
                        <li class="treeview">
                            <a href="#"><i class="fa fa-share"></i> <span>Pagos</span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{ url('/runner/pagos') }}"><i class="fa fa-circle-o"></i>Lista Pagos</a></li>
                                <li><a href="{{ url('/runner/comprobantes/cuadre') }}"><i class="fa fa-circle-o"></i> Cuadre</a></li>
                            </ul>
                        </li>
                        <li><a href="{{ url('/runner/inscripciones/kit') }}"><i class="fa fa-circle-o"></i> Entrega de kit</a></li>
                    </ul>
                </li>
                {{--<li class="treeview">--}}
                    {{--<a href="#">--}}
                        {{--<i class="fa fa-files-o"></i>--}}
                        {{--<span>Estadísticas</span>--}}
                        {{--<i class="fa fa-angle-left pull-right"></i>--}}
                    {{--</a>--}}
                    {{--<ul class="treeview-menu">--}}
                        {{--<li><a href="{{ url('#') }}"><i class="fa fa-circle-o"></i>Inscriptos por edades</a></li>--}}
                        {{--<li><a href="{{ url('#') }}"><i class="fa fa-circle-o"></i>Inscriptos por género</a></li>--}}
                        {{--<li><a href="{{ url('#') }}"><i class="fa fa-circle-o"></i>Inscriptos por circuitos</a></li>--}}
                        {{--<li><a href="{{ url('#') }}"><i class="fa fa-circle-o"></i>Inscriptos por categorías</a></li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
                {{--<li>--}}
                    {{--<a href="#">--}}
                        {{--<i class="fa fa-plus-square"></i> <span>Ayuda</span>--}}
                        {{--<small class="label pull-right bg-red">PDF</small>--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li>--}}
                    {{--<a href="#">--}}
                        {{--<i class="fa fa-info-circle"></i> <span>Acerca De...</span>--}}
                        {{--<small class="label pull-right bg-yellow">FDG</small>--}}
                    {{--</a>--}}
                {{--</li>--}}
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>
    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Sistema de inscripción Guayaco Runner</h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            {{--<div class="row">--}}
                                {{--<div class="col-md-12">--}}
                                    <!--Contenido-->
                                    @yield('contenido')
                                            <!--Fin Contenido-->
                                {{--</div>--}}
                            {{--</div>--}}
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section>
    </div><!-- /.content-wrapper -->
    <!--Fin-Contenido-->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0
        </div>
        <strong>Copyright &copy; 2016-2020 <a href="#">FDG</a>.</strong> All rights reserved.
        {{--<strong>Copyright &copy; 2016-2020 <a href="http://www.fedeguayas.com.ec">FDG</a>.</strong> All rights reserved.--}}
    </footer>
    <!-- jQuery 2.1.4 -->
    <script src="{{asset('plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('dist/js/app.min.js')}}"></script>
    <!-- Mis Script -->
    <script src="{{asset('dist/js/scripts.js')}}"></script>
</div>
</body>
</html>