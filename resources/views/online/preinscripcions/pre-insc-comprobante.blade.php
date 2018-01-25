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
<table align="center" cellpadding="5" cellspacing="10" style=" width: 90%;">
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
</table>

<div class="logo">

</div>

{{--<div style="width:200px; height: 20px;">--}}
    {{--<img alt="LOGO" src="img/camp/fdg-logo.png" style="width: 200px; height: 80px; position: absolute; top:  15px; right: 15px;"/>--}}
{{--</div>--}}

</body>
</html>
