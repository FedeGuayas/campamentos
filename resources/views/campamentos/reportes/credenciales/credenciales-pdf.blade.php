<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>
    <link rel="stylesheet" href="css/pdf.css">
    <link href="css/bootstrap.css" rel="stylesheet">
</head>


<body>

@foreach($inscripciones->chunk(4) as $inscChunck)
    <div style="width:100%; font-size:0;">
        @foreach($inscChunck as $insc)
            <div class="credencial_img">
                <table align="center" border="0" cellpadding="1" width="225px"
                       style="font-size: 10px; text-align: left;">
                    <tr>
                        <td>
                            <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                        </td>
                    </tr>
                    <tr>
                        <th width="20%">Nombres:</th>
                        <td>
                            @if ($insc->alumno_id==0)
                                {{ $insc->factura->representante->persona->apellidos.' '. $insc->factura->representante->persona->nombres}}
                            @else
                                {{ $insc->alumno->persona->apellidos.' '.$insc->alumno->persona->nombres }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Edad:</th>
                        <td>
                            @if ($insc->alumno_id==0)
                                {{$insc->factura->representante->getEdad($insc->factura->representante->persona->fecha_nac)}}
                            @else
                                {{$insc->alumno->getEdad($insc->alumno->persona->fecha_nac)}}
                            @endif
                            <p style="display: inline">   __Registro: <span>{{sprintf("%'.05d",$insc->id )}}</span></p>
                        </td>
                    </tr>
                    <tr>
                        <th>Escenario:</th>
                        <td>
                            {{ $insc->calendar->program->escenario->escenario }}
                        </td>
                    </tr>
                    <tr>
                        <th>Disciplina:</th>
                        <td>
                            {{ $insc->calendar->program->disciplina->disciplina }}
                        </td>
                    </tr>
                    <tr>
                        <th>Horario:</th>
                        <td>
                            {{ $insc->calendar->dia->dia}}
                            <br>
                            {{ $insc->calendar->horario->start_time}}-{{ $insc->calendar->horario->end_time}}
                        </td>
                    </tr>
                </table>
            </div>
        @endforeach
    </div>

    {{--<div class="page-break"></div>--}}
@endforeach


</body>
</html>
