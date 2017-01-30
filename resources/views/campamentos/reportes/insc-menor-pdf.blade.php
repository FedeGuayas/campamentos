<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>
</head>
<body>

<header>
    <div class="header">
        <table align="" border="0" cellpadding="0" cellspacing="0" style=" width: 100%; position: fixed; left: 0px; top: -30px; right: 0px;">
            <thead>
            <tr>
                <th style="width: 160px; text-align: left; text-decoration: underline; ">REGISTRO # {{sprintf("%'.05d",$inscripcion->id)}}</th>
                {{--<th style=" text-decoration: underline;">COMPROBANTE # {{$inscripcion->factura->id}}</th>--}}
                <th style="width:200px; height: 20px; text-align: right"><img alt="LOGO" src="img/camp/fdg-logo.png" style="width: 200px; height: 80px; "/>
                </th>
            </tr>
            </thead>
        </table>
        <br><br>
        <p style="text-align: center;"><span><b>MODULO:</b></span> {{$inscripcion->calendar->program->modulo->modulo}}. <span><b> COMPROBANTE # </b></span>{{$inscripcion->factura->id}}  </p>
        <p style="text-align: center;"><span><b>INSCRIPCION EN CAMPAMENTOS DEPORTIVOS FEDEGUAYAS</b></span></p>
    </div>

</header>

<main style="font-size: 14px;">

    <table align="center" border="0" cellpadding="2" cellspacing="0" style=" width: 720px; ">
        <tr>
            <th align="left" style="text-decoration: underline; width: 350px;">DATOS DEL INSCRITO</th>
            <th align="left" style="text-decoration: underline;">DATOS DEL REPRESENTANTE</th>
        </tr>
        <tr>
            <td>
                <table align="left" border="0" cellpadding="0" cellspacing="0" style=" width: 100%; ">
                    <tr>
                        <th align="left" style="width: 80px;">ALUMNO:</th>
                        <td>{{$inscripcion->alumno->persona->apellidos.' '.$inscripcion->alumno->persona->nombres}}</td>
                    </tr>
                    {{--<tr>--}}
                        {{--<th align="left">FECHA DE NACIMIENTO:</th>--}}
                        {{--<td>{{$inscripcion->alumno->persona->fecha_nac}}</td>--}}
                    {{--</tr>--}}
                    <tr>
                        <th align="left">EDAD:</th>
                        <td>{{$inscripcion->alumno->getEdad($inscripcion->alumno->persona->fecha_nac)}}</td>
                    </tr>
                    <tr>
                        <th align="left">SEXO:</th>
                        <td>{{$inscripcion->alumno->persona->genero}}</td>
                    </tr>
                </table>
            </td>
            <td>
                <table align="right" border="0" cellpadding="0" cellspacing="0" style=" width: 100%; ">
                    <tr>
                        <th align="left" style="width: 130px;">REPRESENTANTE:</th>
                        <td>{{$inscripcion->factura->representante->persona->apellidos.' '.$inscripcion->factura->representante->persona->nombres}}</td>
                    </tr>
                    {{--<tr>--}}
                        {{--<th align="left">DIRECCION</th>--}}
                        {{--<td>{{$inscripcion->factura->representante->persona->direccion}}</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<th align="left">TEEFONO</th>--}}
                        {{--<td>{{$inscripcion->factura->representante->persona->telefono}}</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<th align="left">CORREO ELECTRONICO</th>--}}
                        {{--<td>{{$inscripcion->factura->representante->persona->email}}</td>--}}
                    {{--</tr>--}}
                </table>
            </td>
        </tr>
    </table>

    <br><br><br><br><br>

    <table align="center" border="0" cellpadding="2" cellspacing="0" style=" width: 720px; ">
        <tr>
            <th align="left" style="text-decoration: underline; width: 350px;">DATOS DEL CURSO</th>
            <th align="left" style="text-decoration: underline;">DATOS DE LA INSCRIPCION</th>
        </tr>
        <tr>
            <td>
                <table align="left" border="0" cellpadding="0" cellspacing="0" style=" width: 100%; ">
                    <tr >
                        <th align="left" style="width: 80px;">ESCENARIO:</th>
                        <td>{{$inscripcion->calendar->program->escenario->escenario}}</td>
                    </tr>
                    <tr >
                        <th align="left">DISCIPLINA:</th>
                        <td>{{$inscripcion->calendar->program->disciplina->disciplina}}</td>
                    </tr>
                    <tr >
                        <th align="left">DIAS:</th>
                        <td>{{$inscripcion->calendar->dia->dia}}</td>
                    </tr>
                    <tr >
                        <th align="left">HORARIO:</th>
                        <td>{{$inscripcion->calendar->horario->start_time.'-' .$inscripcion->calendar->horario->end_time }}</td>
                    </tr>
                </table>
            </td>
            <td>
                <table align="right" border="0" cellpadding="0" cellspacing="0" style=" width: 349px; ">
                    <tr >
                        <th align="left" style="width: 30px;">DESCUENTO:</th>
                        <td>
                            @if($inscripcion->factura->descuento==null || $inscripcion->factura->descuento==0)
                                NO
                            @else
                                SI
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th align="left" >INSCRIPCION:</th>
                        <td>
                            @if($inscripcion->factura->descuento==null || $inscripcion->factura->descuento==0)
                                INDIVIDUAL
                            @else
                               INSCRIPCION, {{$inscripcion->factura->descuentos->descripcion}}
                            @endif
                        </td>
                    </tr>

                    <tr >
                        <th align="left">FORMA DE PAGO:</th>
                        <td>{{$inscripcion->factura->pago->forma}}</td>
                    </tr>
                    <tr >
                        <th align="left">USUARIO:</th>
                        <td>{{$inscripcion->user->getNameAttribute()}}</td>
                    </tr>
                    <tr >
                        <th align="left">CANCELADO:</th>
                        <td>$ {{number_format($inscripcion->factura->total,2,'.',' ')}}</td>
                    </tr>
                    {{--<tr>--}}
                        {{--<th align="left"  style="width: 130px;">MODULO:</th>--}}
                        {{--<td>{{$inscripcion->calendar->program->modulo->modulo}}</td>--}}
                    {{--</tr>--}}
                    <tr>
                        <th align="left"  style="width: 130px;">FECHA:</th>
                        <td>{{$inscripcion->created_at}}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</main>

<br><br><br><br><br><br><br><br>

<footer style="font-size: 12px">
    <table align="center" border="0" cellspacing="0" style="width:100%; font-style: italic; text-align : justify; ">
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

    <br>
    <hr>

    <table align="center" border="0" cellpadding="0" cellspacing="0" style="width:100%; text-align : justify; ">
        <tr>
            <td>
                <p>Guayaquil, {{$fecha_actual->day}} de {{$month}} del {{$fecha_actual->year}}</p>

                <p align="center"><span><strong>CARTA DE AUTORIZACION Y COMPROMISO</strong></span></p>

                <p>
                    Yo, <span
                            style=" text-decoration: underline;">{{$inscripcion->factura->representante->persona->getNombreAttribute()}}</span>
                    con cédula de ciudadanía # <span
                            style=" text-decoration: underline;">{{$inscripcion->factura->representante->persona->num_doc}}</span>
                    , en mi calidad de representante legal del niño (a) <span
                            style=" text-decoration: underline;">{{$inscripcion->alumno->persona->getNombreAttribute()}}</span>
                    , de <span
                            style=" text-decoration: underline;">{{$inscripcion->alumno->getEdad($inscripcion->alumno->persona->fecha_nac)}}</span>
                    años de edad, autorizo por medio del presente documento para que mi representado/a forme parte del
                    proyecto de Campamentos
                    Deportivos de La Federación Deportiva del Guayas.
                </p>

                <p>
                    Así mismo, se deja constancia que mi representado/a no tiene impedimento físico, psíquico ni
                    emocional para realizar la práctica
                    deportiva de las disciplinas en la/s que lo/la he inscrito.
                </p>

                <p>
                    Como representante legal del niño <span
                            style=" text-decoration: underline;">{{$inscripcion->alumno->persona->getNombreAttribute()}}</span>
                    me responsabilizo por el traslado del mismo de un escenario a otro, ya sea dentro o fuera de los
                    complejos deportivos, para el desarrollo
                    y entrenamiento de las disciplinas deportivas en las que lo/a he inscrito.
                </p>

                <p>
                    Además, declaro mediante este documento que la Federación Deportiva del Guayas queda exonerada y
                    liberada de todo tipo de
                    responsabilidad alguna por cualquier situación que afecte la integridad física, psíquica y/o
                    emocional, que pueda llegar a
                    sufrir mi representado/a a partir de la suscripción de este documento, renunciando a cualquier
                    acción o derecho en contra de
                    La Federación, conforme a lo dispuesto en el artículo 11 del Código Civil vigente.
                </p>

                <p>
                    Para constancia de la presente y ratificación del contenido, suscribo adjuntando copia de mi cédula
                    de ciudadanía.
                </p>

                <br>

                <p align="center">
                    ___________________________
                </p>

                <p align="center">
                    FIRMA <br>
                    CI: {{$inscripcion->factura->representante->persona->num_doc}}
                </p>
            </td>
        </tr>
    </table>



    <p style="font-size: 12px; color: #0a568c; text-align: center; position: fixed; left: 0px; bottom: -180px; right: 0px; height: 150px;">
        Oficina: José Mascote 1103 y Luque. Telfs: 2367856 - 2531488. fedeguayas.com.ec. email: fdg@telconet.net <br>
        Casilla 836 Telegramas y Cables - FEDEGUAYAS. Guayaquil - Ecuador
    </p>

</footer>

</body>
</html>
