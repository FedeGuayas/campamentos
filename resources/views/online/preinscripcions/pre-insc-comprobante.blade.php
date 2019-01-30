<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>
    <link rel="stylesheet" href="css/preinscricion-comprobante-pdf.css">
    <link href="css/bootstrap.css" rel="stylesheet">
</head>
<body>
<br>
<table align="center" cellpadding="0" cellspacing="2" style=" width: 90%;">
    <tr>
        <th align="left">RESERVA N. {{sprintf("%'.05d",$inscripcion->id)}}</th>
        <th align="left">COBRAR HASTA EL: {{$inscripcion->created_at->addDay()->toDateString()}}</th>
    </tr>
    <tr>
        <th>FORMA DE PAGO: {{$inscripcion->factura->pago->forma}}</th>
        <th></th>
    </tr>

    <tr>
        <th colspan="2">DATOS DEL CLIENTE</th>
        <th></th>
    </tr>
    <tr>
        <th colspan="2">
            REPRESENTANTE: {{$inscripcion->factura->representante->persona->nombres.' '.$inscripcion->factura->representante->persona->apellidos}}</th>
        <th>
        </th>
    </tr>
    <tr>
        <th colspan="2">INSCRITO:
            @if ($inscripcion->alumno_id==0)
                {{ $inscripcion->factura->representante->persona->nombres.' '.$inscripcion->factura->representante->persona->apellidos}}
            @else
                {{ $inscripcion->alumno->persona->nombres.' '.$inscripcion->alumno->persona->apellidos }}
            @endif
        </th>
    </tr>
    <tr>
        <th colspan="2">VALOR: $ {{number_format($inscripcion->factura->total,2,'.',' ')}}</th>
        <th></th>
    </tr>

    <tr><td colspan="2"></td><td></td></tr>
    <tr><td colspan="2"></td><td></td></tr>
    <tr><td colspan="2"></td><td></td></tr>

    <tr>
        <th>Escenario</th>
        <th>{{ $inscripcion->calendar->program->escenario->escenario }}</th>
    </tr>
    <tr>
        <th>Modulo</th>
        <th>{{ $inscripcion->calendar->program->modulo->modulo }}</th>
    </tr>
    <tr>
        <th>Fecha (Inicio / Fin)</th>
        <th>{{ $inscripcion->calendar->program->modulo->inicio }}
            / {{ $inscripcion->calendar->program->modulo->fin }}</th>
    </tr>
    <tr>
        <th>Disciplina</th>
        <th>{{ $inscripcion->calendar->program->disciplina->disciplina }}</th>
    </tr>

    <tr>
        <th>CI Rep.</th>
        <th>{{ $inscripcion->factura->representante->persona->num_doc }}</th>
    </tr>
</table>
<br><br>
<br><br>
<table align="center" border="0" style=" width: 90%;">
    <tr>
        <td style="font-style: italic ">
            <b>Ud debe presentar esta imagen en Western Union u oficina de Fedeguayas para realizar el pago y confirmar la inscripción.</b>
        </td>
    </tr>

</table>

<div class="logo"></div>

{{--<div style="width:200px; height: 20px;">--}}
{{--<img alt="LOGO" src="img/camp/fdg-logo.png" style="width: 200px; height: 80px; position: absolute; top:  15px; right: 15px;"/>--}}
{{--</div>--}}

</body>
</html>
