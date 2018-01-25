<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>
    <link href="css/bootstrap.css" rel="stylesheet">
    {{--<link href="../../../../../public/css/pdf.css" rel="stylesheet">--}}
    <script src="js/jquery-3.1.0.min.js" type="text/javascript"></script>
    <script src="js/tablesorter.min.js" type="text/javascript"></script>
    {{--<script src="../../../../../public/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>--}}
    <style>
        body{
            margin: -20px 5px -100px 20px;
            /*font-family: sans-serif;*/
        }
        @page {
            margin: 180px 50px;
        }
        header {
            position: fixed;
            left: 20px;
            top: -160px;
            padding: 5px;
            right: 0px;
            height: 120px;
            /*background-color: #ddd;*/
            text-align: left;
            border-bottom: 2px solid #ddd;
        }
        header h1{
            margin: 10px 0;
        }
        header h2{
            margin: 0 0 10px 0;
        }
        footer {
            position: fixed;
            left: 0px;
            bottom: -120px;
            right: 0px;
            height: 40px;
            border-bottom: 2px solid #ddd;
        }
        footer .page:after {
            content: counter(page);
        }
        footer table {
            width: 100%;
        }
        footer p {
            text-align: right;
        }
        footer .izq {
            text-align: left;
        }
    </style>


</head>


<body>
<header>
    <h2>Campamentos Deportivos</h2>
    <table style="font-size: 11px;">
        <tr>
           <td style="width: 350px">
               MODULO: {{$curso->program->modulo->modulo}}
           </td>
            <td>ESCENARIO: {{$curso->program->escenario->escenario}}</td>
        </tr>
        <tr>
            <td>DISCIPLINA: {{$curso->program->disciplina->disciplina}}</td>
            <td>HORARIO: {{ $curso->horario->start_time.'-'.$curso->horario->end_time}}</td>
        </tr>
        <tr>
            <td colspan="2">DIAS: {{$curso->dia->dia}}</td>
            <td></td>
        </tr>

    </table>

</header>

{{--<div style="width:100%; font-size:0;">--}}
<div id="content">
    <table  align="left" border="0" cellpadding="2" style="font-size: 10px; text-align: left; width: 70%" id="table_listado">
        <thead>
        <tr>
            <th align="left" width="30px">No.</th>
            <th align="left" width="180px">APELLIDOS</th>
            <th align="left" width="180px">NOMBRES</th>
            <th align="left" >EDAD</th>
            <th align="center" width="180px">COMPROBANTE</th>
        </tr>
        </thead>
        <tbody>
        @foreach($inscripciones as $insc)
            <tr>
                <td> {{$numero++}}</td>
                <td>
                    @if ($insc->alumno_id==0)
                        {{ $insc->factura->representante->persona->apellidos}}
                    @else
                        {{ $insc->alumno->persona->apellidos}}
                    @endif
                </td>
                <td>
                    @if ($insc->alumno_id==0)
                        {{ $insc->factura->representante->persona->nombres}}
                    @else
                        {{ $insc->alumno->persona->nombres}}
                    @endif

                </td>
                <td>
                    @if ($insc->alumno_id==0)
                        {{$insc->factura->representante->getEdad($insc->factura->representante->persona->fecha_nac)}}
                    @else
                        {{$insc->alumno->getEdad($insc->alumno->persona->fecha_nac)}}
                    @endif
                </td>
                <td align="center">
                    {{sprintf("%'.05d",$insc->id)}}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{--<p style="page-break-before: always;"> Podemos romper la página en cualquier momento...</p>--}}

</div>

<footer>
    <table>
        <tr>
            <td>
                <p class="izq">
                    Campamentos Deportivos 2017
                </p>
            </td>
            <td>
                <p class="page">
                    Página
                </p>
            </td>
        </tr>
    </table>
</footer>
<script>
    $(document).ready(function()
        {
            $("#table_listado").tablesorter( {sortList: [[0,3]]} );
        }
    );
</script>

</body>
</html>
