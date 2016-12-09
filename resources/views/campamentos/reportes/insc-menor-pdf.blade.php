<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>
</head>
<body>
<table align="left" border="0" cellpadding="1" cellspacing="1" style="width:100%;">
    <tbody>
    <tr>
        <td>REGISTRO # {{$inscripcion->id}}</td>
        <td style="font-size: 20px;"><span>CAMPAMENTOS DEPORTIVOS</span></td>
        <th><img alt="LOGO" src="img/camp/fdg-logo.png" style="width: 200px; height: 100px; " /></th>
    </tr>
    </tbody>
</table>

<p>&nbsp;</p>

<p>&nbsp;</p>

<p>&nbsp;</p>

<table border="0" cellpadding="1" cellspacing="1" style="width:100%;">
    <thead>
    <tr>
        <th scope="col" style="background-color: rgb(204, 204, 204);">ALUMNO</th>
        <th scope="col" style="background-color: rgb(204, 204, 204);">EDAD</th>
        <th scope="col" style="background-color: rgb(204, 204, 204);">SEXO</th>
        <th scope="col" style="background-color: rgb(204, 204, 204);">CI</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>{{$inscripcion->alumno->persona->getNombreAttribute()}}</td>
        <td>{{$inscripcion->alumno->getEdad($inscripcion->alumno->persona->fecha_nac)}}</td>
        <td>{{$inscripcion->alumno->persona->genero}}</td>
        <td>{{$inscripcion->alumno->persona->num_doc}}</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    </tbody>
</table>

<p>&nbsp;</p>

<table border="0" cellpadding="1" cellspacing="1" style="width:100%;">
    <thead>
    <tr>
        <th scope="col" style="background-color: rgb(204, 204, 204);">MODULO</th>
        <th scope="col" style="background-color: rgb(204, 204, 204);">ESCENARIO</th>
        <th scope="col" style="background-color: rgb(204, 204, 204);">DISCIPLINA</th>
        <th scope="col" style="background-color: rgb(204, 204, 204);">DIAS</th>
        <th scope="col" style="background-color: rgb(204, 204, 204);">HORARIO</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>{{$inscripcion->calendar->program->modulo->modulo}}</td>
        <td>{{$inscripcion->calendar->program->escenario->escenario}}</td>
        <td>{{$inscripcion->calendar->program->disciplina->disciplina}}</td>
        <td>{{$inscripcion->calendar->dia->dia}}</td>
        <td>{{$inscripcion->calendar->horario->start_time.'-' .$inscripcion->calendar->horario->end_time }}</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    </tbody>
</table>

<p>&nbsp;</p>

<table border="0" cellpadding="1" cellspacing="1" style="width:500px;">
    <thead>
    <tr>
        <th scope="col" style="background-color: rgb(204, 204, 204);">USUARIO</th>
        <th scope="col" style="background-color: rgb(204, 204, 204);">TOTAL CANCELADO</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>{{$inscripcion->user->getNameAttribute()}}</td>
        <td>{{$inscripcion->factura->total}}</td>
    </tr>
    </tbody>
</table>

<p>&nbsp;</p>
<br>
<hr>
<p><span style="font-size:12px;">Guayaquil, {{$fecha_actual->day}} de {{$fecha_actual->month}} del {{$fecha_actual->year}}</span></p>

<p align="center"><span style="font-size:9px;"><strong>CARTA DE AUTORIZACION Y COMPROMISO</strong></span></p>

<p><span style="font-size:9px;">Yo, {{$inscripcion->factura->representante->persona->getNombreAttribute()}}<span style="font-size:10px;"> con cédula de ciudadanía # {{$inscripcion->factura->representante->persona->num_doc}}, en mi calidad de representante legal del niño (a) {{$inscripcion->alumno->persona->getNombreAttribute()}}, de {{$inscripcion->alumno->getEdad($inscripcion->alumno->persona->fecha_nac)}} años de edad, autorizo por medio del presente documento para que mi representado/a forme parte del proyecto de Campamentos Deportivos de La Federación Deportiva del Guayas.</span></span></p>

<p><span style="font-size:10px;">Así mismo, se deja constancia que mi representado/a no tiene impedimento físico, psíquico ni emocional para realizar la práctica deportiva de las disciplinas en la/s que lo/la he inscrito.</span></p>

<p><span style="font-size:10px;">Como representante legal del niño {{$inscripcion->alumno->persona->getNombreAttribute()}} me responsabilizo por el traslado del mismo de un escenario a otro, ya sea dentro o fuera de los complejos deportivos, para el desarrollo y entrenamiento de las disciplinas deportivas en las que lo/a he inscrito.</span></p>

<p><span style="font-size:10px;">Además, declaro mediante este documento que la Federación Deportiva del Guayas queda exonerada y liberada de todo tipo de responsabilidad alguna por cualquier situación que afecte la integridad física, psíquica y/o emocional, que pueda llegar a sufrir mi representado/a a partir de la suscripción de este documento, renunciando a cualquier acción o derecho en contra de La Federación, conforme a lo dispuesto en el artículo 11 del Código Civil vigente.</span></p>

<p><span style="font-size:10px;">Para constancia de la presente y ratificación del contenido, suscribo adjuntando copia de mi cédula de ciudadanía.</span></p>

<p style="text-align: center;"><span style="font-size:10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;___________________________</span></p>

<p style="text-align: center;"><span style="font-size:10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FIRMA</span></p>

<p style="text-align: center;"><span style="font-size:10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; _____________________________</span></p>

<p style="text-align: center;"><span style="font-size:10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; C.C.</span></p>
</body>
</html>
