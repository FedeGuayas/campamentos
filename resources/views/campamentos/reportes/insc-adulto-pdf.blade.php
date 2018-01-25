<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>
    <link rel="stylesheet" href="css/pdf.css">
    <link href="css/bootstrap.css" rel="stylesheet">
</head>
<body>

<header>
    <div style="width: 160px; text-align: left; text-decoration: underline; position: fixed; top: 15px; left: 15px; ">
        <b>REGISTRO # {{sprintf("%'.05d",$inscripcion->id)}}</b>
    </div>
    <div style="width:200px; height: 20px;">
        <img alt="LOGO" src="img/camp/fdg-logo.png" style="width: 200px; height: 80px; position: absolute; top:  15px; right: 15px;"/>
    </div>
    <br><br>
    <div style="text-align: center; position: relative">
        <p>
            <span><b>MODULO:</b></span> {{$inscripcion->calendar->program->modulo->modulo}}. <span><b> COMPROBANTE# </b></span>{{$inscripcion->factura->id}}
        </p>
        <p>
            <span><b>
             		@if ($inscripcion->factura->total==0 && $inscripcion->factura->descuentos->descripcion=='CORTESIA')
                        CURSO DE CORTESIA EN CAMPAMENTOS DEPORTIVOS FEDEGUAYAS
                    @else
                        INSCRIPCION EN CAMPAMENTOS DEPORTIVOS FEDEGUAYAS
                    @endif
            </b></span>
        </p>
    </div>
</header>


<div class="limpia_float content">
    <table align="center" border="0" cellpadding="0" cellspacing="0" style=" width: 720px; font-size: 12px;">
        <tr>
            <th align="left" style="text-decoration: underline">DATOS DEL INSCRITO</th>
        </tr>
        <tr>
            <td>
                <table align="center" border="0" cellpadding="0" cellspacing="0" style=" width: 400px; font-size: 12px; ">
                    <tr>
                        <th  align="left" style="width: 130px;">ALUMNO:</th>
                        <td>{{$inscripcion->factura->representante->persona->apellidos.' '.$inscripcion->factura->representante->persona->nombres}}</td>
                    </tr>
                    <tr>
                        <th align="left">EDAD:</th>
                        <td>{{$inscripcion->factura->representante->getEdad($inscripcion->factura->representante->persona->fecha_nac)}}</td>
                    </tr>
                    <tr>
                        <th align="left">SEXO:</th>
                        <td>{{$inscripcion->factura->representante->persona->genero}}</td>
                    </tr>
                    <tr>
                        <th align="left">DIRECCION:</th>
                        <td>{{$inscripcion->factura->representante->persona->direccion}}</td>
                    </tr>
                    <tr>
                        <th align="left">TEEFONO:</th>
                        <td>{{$inscripcion->factura->representante->persona->telefono}}</td>
                    </tr>
                    <tr>
                        <th align="left">CORREO:</th>
                        <td>{{$inscripcion->factura->representante->persona->email}}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br>
    <table align="center" border="0" cellpadding="0" cellspacing="0" style=" width: 720px; font-size: 12px; ">
        <tr>
            <th align="left" style="text-decoration: underline; width: 350px;">DATOS DEL CURSO</th>
            <th align="left" style="text-decoration: underline">DATOS SOBRE LA INSCRIPCION</th>
        </tr>
        <tr>
            <td>
                <table align="center" border="0" cellpadding="0" cellspacing="0" style=" width: 100%;">
                    <tr>
                        <th align="left"  style="width: 100px;">ESCENARIO:</th>
                        <td>{{$inscripcion->calendar->program->escenario->escenario}}</td>
                    </tr>
                    <tr>
                        <th align="left">DISCIPLINA:</th>
                        <td>{{$inscripcion->calendar->program->disciplina->disciplina}}</td>
                    </tr>
                    <tr>
                        <th align="left">DIAS:</th>
                        <td>{{$inscripcion->calendar->dia->dia}}</td>
                    </tr>
                    <tr>
                        <th align="left">HORARIO:</th>
                        <td>{{$inscripcion->calendar->horario->start_time.'-' .$inscripcion->calendar->horario->end_time }}</td>
                    </tr>
                </table>
            </td>
            <td>
                <table align="center" border="0" cellpadding="0" cellspacing="0" style=" width: 349px;">
                    <tr>
                        <th align="left" style="width: 30px;" >DESCUENTO:</th>
                        <td>
                            @if($inscripcion->factura->descuento==null || $inscripcion->factura->descuento==0)
                                NO
                            @else
                                SI
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th align="left">INSCRIPCION:</th>
                        <td>
                            @if($inscripcion->factura->descuento==null || $inscripcion->factura->descuento==0)
                                INDIVIDUAL
                            @else
                                INSCRIPCION, {{$inscripcion->factura->descuentos ? $inscripcion->factura->descuentos->descripcion : ''}}
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th align="left">FORMA DE PAGO:</th>
                        <td>{{$inscripcion->factura->pago->forma}}</td>
                    </tr>
                    <tr>
                        <th align="left">USUARIO:</th>
                        <td>{{$inscripcion->user->getNameAttribute()}}</td>
                    </tr>
                    <tr>
                        <th align="left">CANCELADO:</th>
                        <td>$ {{number_format($inscripcion->factura->total,2,'.',' ')}}</td>
                    </tr>
                    <tr>
                        <th align="left"  style="width: 130px;">FECHA:</th>
                        <td>{{$inscripcion->created_at}}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
<br>
<div class="">
    <table align="center" border="0" cellspacing="0" style="width:90%; font-style: italic; text-align : justify; font-size: 11px; margin-top: -20px;">
        <tr>
            <td>
                <p>
                    Las partes dejan constancia que el valor entregado como mensualidad por el Campamento Escuelas
                    Deportivas Fedeguayas no será
                    reembolsado bajo ninguna circunstancia y quedará como beneficio de la Federación Deportiva del
                    Guayas, aun cuando el CLIENTE
                    llegare a desistir de su participación en el campamento en mención, a excepción de que el
                    desistimientos se produzca dentro de los
                    3 primeros días contando a partir del inicio del módulo.
                    <br>
                    Los cambios de horario se podrán realizar dentro de la primera semana de inicio del módulo.
                </p>
            </td>
        </tr>
    </table>
</div>
<hr>

<div>
    <table align="left" border="1" cellpadding="5" cellspacing="0" style="width:60%; text-align : justify; font-size: 11px; margin-left: 30px; margin-top: -20px; ">
        <tr>
            <td>
                <p>Guayaquil, {{$fecha_actual->day}} de {{$month}} del {{$fecha_actual->year}}</p>

                <p align="center"><span><strong>CARTA DE AUTORIZACION Y COMPROMISO</strong></span></p>
                <p>
                    Yo, <span
                            style=" text-decoration: underline;">{{$inscripcion->factura->representante->persona->getNombreAttribute()}}</span>
                    con cédula de ciudadanía # <span
                            style=" text-decoration: underline;">{{$inscripcion->factura->representante->persona->num_doc}}</span>,
                    de <span
                            style=" text-decoration: underline;">{{$inscripcion->factura->representante->getEdad($inscripcion->factura->representante->persona->fecha_nac)}}</span>
                    años de edad, autorizo por medio del presente documento formar parte del proyecto de Campamentos
                    Deportivos de La Federación Deportiva del Guayas.
                </p>
                <p>
                    Dejo constancia que yo, <span
                            style=" text-decoration: underline;">{{$inscripcion->factura->representante->persona->getNombreAttribute()}}</span>
                    no tengo impedimento físico, psíquico ni emocional para realizar la práctica deportiva de las
                    disciplinas en la/s que lo/la me he inscrito.
                </p>
                <p>
                    Como representante legal, me responsabilizo por el traslado del mismo de un escenario a otro, ya sea
                    dentro o fuera de los complejos deportivos, para el desarrollo
                    y entrenamiento de las disciplinas deportivas en las que me he inscrito.
                </p>
                <p>
                    Además, declaro mediante este documento que la Federación Deportiva del Guayas queda exonerada y
                    liberada de todo tipo de responsabilidad alguna por cualquier
                    situación que afecte mi integridad física, psíquica y/o emocional, que pueda llegar a sufrir a
                    partir de la suscripción de este documento, renunciando a cualquier
                    acción o derecho en contra de La Federación, conforme a lo dispuesto en el artículo 11 del Código
                    Civil vigente.
                </p>
                <p>
                    Para constancia de la presente y ratificación del contenido, suscribo adjuntando copia de mi cédula
                    de ciudadanía.
                </p>
                <br>
                <p align="center">
                    ______________________________________________________________________
                </p>

                <p align="center">
                    FIRMA <br>
                    Nombre: {{$inscripcion->factura->representante->persona->getNombreAttribute()}}<br>
                    CI: {{$inscripcion->factura->representante->persona->num_doc}}
                </p>
            </td>
        </tr>
    </table>
</div>

<footer>
    <table>
        <tr>
            <td>
                <p>
                    Oficina: José Mascote 1103 y Luque. Telfs: 2367856 - 2531488. fedeguayas.com.ec. email: fdg@telconet
                    .net <br>
                    Casilla 836 Telegramas y Cables - FEDEGUAYAS. Guayaquil - Ecuador
                </p>
            </td>
        </tr>
    </table>
</footer>

{{--<span style="font-family: FontAwesome;  position: absolute; bottom: 500px; right: 240px;">&#xf0c4; </span>--}}
<div class="tijera"></div>

@if ( stristr($inscripcion->calendar->program->modulo->modulo, 'permanente') )
    <div class="credencial_campamentos">
@else
    <div class="credencial_img">
@endif
    <table align="left" border="1" cellpadding="1" width="225px"
           style="font-size: 9px; text-align: left;">
        <tr>
            <td>
                <br><br><br><br><br><br><br><br><br><br><br><br><br>
            </td>
        </tr>
        <tr>
            <th>Modulo:</th>
            <td>
                <b> {{ $inscripcion->calendar->program->modulo->modulo}}</b>
            </td>
        </tr>
        <tr>
            <th>Fecha:</th>
            <td>
                <b> {{ $inscripcion->calendar->program->modulo->inicio}} / {{$inscripcion->calendar->program->modulo->fin}}</b>
            </td>
        </tr>
        <tr>
            <th width="20%">Nombres:</th>
            <td>
                @if ($inscripcion->alumno_id==0)
                    {{ $inscripcion->factura->representante->persona->apellidos.' '. $inscripcion->factura->representante->persona->nombres}}
                @else
                    {{ $inscripcion->alumno->persona->apellidos.' '.$inscripcion->alumno->persona->nombres }}
                @endif
            </td>
        </tr>
        <tr>
            <th>Edad:</th>
            <td>
                @if ($inscripcion->alumno_id==0)
                    {{$inscripcion->factura->representante->getEdad($inscripcion->factura->representante->persona->fecha_nac)}}
                @else
                    {{$inscripcion->alumno->getEdad($inscripcion->alumno->persona->fecha_nac)}}
                @endif
                <p style="display: inline">  /  Registro: <span>{{sprintf("%'.05d",$inscripcion->id )}}</span></p>
            </td>
        </tr>
        <tr>
            <th>Escenario:</th>
            <td style="text-decoration: underline;">
                <b>{{ $inscripcion->calendar->program->escenario->escenario }}</b>
            </td>
        </tr>
        <tr>
            <th>Disciplina:</th>
            <td>
                {{ $inscripcion->calendar->program->disciplina->disciplina }}
            </td>
        </tr>
        <tr>
            <th>Horario:</th>
            <td>
                {{ $inscripcion->calendar->dia->dia}}
                <br>
                {{ $inscripcion->calendar->horario->start_time}}-{{ $inscripcion->calendar->horario->end_time}}
            </td>
        </tr>
    </table>
</div>

</body>
</html>


