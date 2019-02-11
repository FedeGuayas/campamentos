<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <title>Pagina no encontrada:(</title>
    <style>
        html, body {
            height: 100%;
        }
        body{
            background: url({{asset('img/camp/error-bg.jpg')}}) no-repeat center center;
            background-size:100% 100%;
            margin: 0;
            padding: 0;
            width: 100%;
            color: #ffffff;
            display: table;
            font-weight: 100;
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 72px;
            margin-bottom: 40px;
            color: #990000;
        }
        .subtitle {
            font-size: 40px;
            margin-bottom: 40px;
        }
        a{
            display: block;
            color: red;
            text-decoration: none;
            position: relative;
        }
        a:hover{
            color: white;
        }
        a:active{
            color: darkblue;
        }
    </style>
</head>
<body>
<div class="container">
    <img src="{{asset('img/camp/404.png')}}" alt="404 error">
    <div class="content">
        <h1 class="title">Página No Encontrada</h1>
    </div>
    <strong class="subtitle"><a  href="javascript:history.back()">Regresar</a></strong>
</div>


{{--<div class="error-page login-wrap bg-cover height-100-p customscroll d-flex align-items-center flex-wrap justify-content-center pd-20">--}}

    {{--<div class="pd-10">--}}
        {{--<div class="error-page-wrap text-center color-white">--}}

            {{--<img src="{{asset('img/camp/404.png')}}" alt="404 error"--}}
                {{--id="error404">--}}
            {{--<p>Lo sentimos, no se puede acceder a la página que estás buscando.<br>Verifique la URL, <a href="{{url('/')}}">Ir al Inicio</a>.</p>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}
</body>
</html>