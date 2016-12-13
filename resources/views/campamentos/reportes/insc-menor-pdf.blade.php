<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>
</head>
<body>

<header>
    <div class="pull-left">
        <table align="left" border="" cellpadding="10" cellspacing="1" style="width:auto; height: auto">
            <tr>
                <td style="border: solid">REGISTRO # {{sprintf("%'.05d",$inscripcion->id)}}</td>
            </tr>
            <tr>
                <td>COMPROBANTE # {{$inscripcion->factura->id}}</td>
            </tr>
        </table>
    </div>
    <div class="">
        <table align="right" border="0" cellpadding="1" cellspacing="1" style="width: 200px; height: 100px; ">
            <tr>
                <th><img alt="LOGO" src="img/camp/fdg-logo.png" style="width: 200px; height: 100px; "/></th>
            </tr>
        </table>
    </div>
    <br><br><br><br><br>
    <div class="">
        <table align="center" border="0" cellpadding="0" cellspacing="1" style="width:auto; height: auto">
            <tr>
                <td style=""><span>INSCRIPCION EN CAMPAMENTOS DEPORTIVOS FEDEGUAYAS</span></td>
            </tr>
        </table>
    </div>
</header>

<main style="font-size: 10px;">
    <br><br><br>
    <table cellpadding="1" cellspacing="1" style="width:100%;">
        <tr>
            <td>
                <p>Datos del Inscrito</p>
                <table align="center" border="1" cellpadding="0" cellspacing="0" style=" width: auto;">
                    <tr align="lef" style="width: auto">
                        <th style="background-color: rgb(204, 204, 204);">ALUMNO</th>
                        <td>{{$inscripcion->alumno->persona->apellidos.' '.$inscripcion->alumno->persona->nombres}}</td>
                    </tr>
                    <tr align="lef" style="width: auto">
                        <th style="background-color: rgb(204, 204, 204);">FECHA DE NACIMIENTO</th>
                        <td>{{$inscripcion->alumno->persona->fecha_nac}}</td>
                    </tr>
                    <tr align="lef" style="width: auto">
                        <th style="background-color: rgb(204, 204, 204);">EDAD</th>
                        <td>{{$inscripcion->alumno->getEdad($inscripcion->alumno->persona->fecha_nac)}}</td>
                    </tr>
                    <tr align="lef" style="width: auto">
                        <th style="background-color: rgb(204, 204, 204);">SEXO</th>
                        <td>{{$inscripcion->alumno->persona->genero}}</td>
                    </tr>
                </table>
            </td>
            <td>
                <p>Datos del representante</p>
                <table align="center" border="1" cellpadding="0" cellspacing="0" style=" width: auto;">
                    <tr align="lef" style="width: auto">
                        <th style="background-color: rgb(204, 204, 204);">REPRESENTANTE</th>
                        <td>{{$inscripcion->factura->representante->persona->apellidos.' '.$inscripcion->factura->representante->persona->nombres}}</td>
                    </tr>
                    <tr align="lef" style="width: auto">
                        <th style="background-color: rgb(204, 204, 204);">DIRECCION</th>
                        <td>{{$inscripcion->factura->representante->persona->direccion}}</td>
                    </tr>
                    <tr align="lef" style="width: auto">
                        <th style="background-color: rgb(204, 204, 204);">TEEFONO</th>
                        <td>{{$inscripcion->factura->representante->persona->telefono}}</td>
                    </tr>
                    <tr align="lef" style="width: auto">
                        <th style="background-color: rgb(204, 204, 204);">CORREO ELECTRONICO</th>
                        <td>{{$inscripcion->factura->representante->persona->email}}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <p>Datos del curso</p>
                <table align="center" border="1" cellpadding="0" cellspacing="0" style="width:auto;">
                    <tr align="lef" style="width: auto">
                        <th style="width: auto; background-color: rgb(204, 204, 204);">ESCENARIO</th>
                        <td>{{$inscripcion->calendar->program->escenario->escenario}}</td>
                    </tr>
                    <tr align="lef" style="width: auto">
                        <th style="width: auto;  background-color: rgb(204, 204, 204);">DISCIPLINA</th>
                        <td>{{$inscripcion->calendar->program->disciplina->disciplina}}</td>
                    </tr>
                    <tr align="lef" style="width: auto">
                        <th style="width: auto; background-color: rgb(204, 204, 204);">DIAS</th>
                        <td>{{$inscripcion->calendar->dia->dia}}</td>
                    </tr>
                    <tr align="lef" style="width: auto">
                        <th style="width: auto; background-color: rgb(204, 204, 204);">HORARIO</th>
                        <td>{{$inscripcion->calendar->horario->start_time.'-' .$inscripcion->calendar->horario->end_time }}</td>
                    </tr>
                    <tr align="lef" style="width: auto">
                        <th style="width: auto; background-color: rgb(204, 204, 204);">MODULO</th>
                        <td>{{$inscripcion->calendar->program->modulo->modulo}}</td>
                    </tr>
                </table>
            </td>
            <td>
                <p>Datos sobre la inscripción</p>
                <table align="center" border="1" cellpadding="0" cellspacing="0" style="width:auto;">
                    <tr align="lef" style="width: auto">
                        <th style="width: auto; background-color: rgb(204, 204, 204);">TIPO DE INSCRIPCION</th>
                        <td>
                            @if( count($inscripcion->factura_id)>1)
                                MULTIPLE
                            @else
                                IDIVIDUAL
                            @endif
                        </td>
                    </tr>
                    <tr align="lef" style="width: auto">
                        <th style="width: auto;  background-color: rgb(204, 204, 204);">APLICA DESCUENTO</th>
                        <td>
                            @if($inscripcion->factura->descuento==null || $inscripcion->factura->descuento==0)
                                NO
                            @else
                                SI
                            @endif
                        </td>
                    </tr>
                    <tr align="lef" style="width: auto">
                        <th style="width: auto; background-color: rgb(204, 204, 204);">FORMA DE PAGO</th>
                        <td>{{$inscripcion->factura->pago->forma}}</td>
                    </tr>
                    <tr align="lef" style="width: auto">
                        <th style="width: auto; background-color: rgb(204, 204, 204);">USUARIO</th>
                        <td>{{$inscripcion->user->getNameAttribute()}}</td>
                    </tr>
                    <tr align="lef" style="width: auto">
                        <th style="width: auto; background-color: rgb(204, 204, 204);">CANCELADO</th>
                        <td>$ {{number_format($inscripcion->factura->total,2,'.',' ')}}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</main>

<br><br>

<footer style="font-size: 10px">
    <table align="center" border="0" cellspacing="0"  style="width:80%; font-style: italic; text-align : justify; ">
        <tr>
            <td>
                <p>
                    Las partes dejan constancia que el valor entregado como mensualidad por el Campamento Escuelas Deportivas Fedeguayas no será
                    reembolsado bajo ninguna circunstancia y quedará como beneficio de la Federación Deportiva del Guayas, aun cuando el CLIENTE
                    llegare a desistir de su participación en el campamento en mención, a excepción de que el desistimientos se produzca dentro de los
                    3 primeros días contando a partir del inicio del módulo.
                    <br>
                    Los cambios de horario se podrán realizar dentro de la primera semana de inicio del módulo.
                </p>
            </td>
        </tr>
    </table>

    <br><br>

    <table align="center" border="1" cellpadding="10" cellspacing="10" style="width:90%; text-align : justify; ">
        <tr>
            <td>
                <p>Guayaquil, {{$fecha_actual->day}} de {{$fecha_actual->month}} del {{$fecha_actual->year}}</p>

                <p align="center"><span><strong>CARTA DE AUTORIZACION Y COMPROMISO</strong></span></p>

                <p>
                    Yo, <span style=" text-decoration: underline;">{{$inscripcion->factura->representante->persona->getNombreAttribute()}}</span>
                    con cédula de ciudadanía # <span style=" text-decoration: underline;">{{$inscripcion->factura->representante->persona->num_doc}}</span>
                    , en mi calidad de representante legal del niño (a) <span style=" text-decoration: underline;">{{$inscripcion->alumno->persona->getNombreAttribute()}}</span>
                    , de <span style=" text-decoration: underline;">{{$inscripcion->alumno->getEdad($inscripcion->alumno->persona->fecha_nac)}}</span>
                    años de edad, autorizo por medio del presente documento para que mi representado/a forme parte del proyecto de Campamentos
                    Deportivos de La Federación Deportiva del Guayas.
                </p>

                <p>
                    Así mismo, se deja constancia que mi representado/a no tiene impedimento físico, psíquico ni emocional para realizar la práctica
                    deportiva de las disciplinas en la/s que lo/la he inscrito.
                </p>

                <p>
                    Como representante legal del niño <span style=" text-decoration: underline;">{{$inscripcion->alumno->persona->getNombreAttribute()}}</span>
                    me responsabilizo por el traslado del mismo de un escenario a otro, ya sea dentro o fuera de los complejos deportivos, para el desarrollo
                    y entrenamiento de las disciplinas deportivas en las que lo/a he inscrito.
                </p>

                <p>
                    Además, declaro mediante este documento que la Federación Deportiva del Guayas queda exonerada y liberada de todo tipo de
                    responsabilidad alguna por cualquier situación que afecte la integridad física, psíquica y/o emocional, que pueda llegar a
                    sufrir mi representado/a a partir de la suscripción de este documento, renunciando a cualquier acción o derecho en contra de
                    La Federación, conforme a lo dispuesto en el artículo 11 del Código Civil vigente.
                </p>

                <p>
                    Para constancia de la presente y ratificación del contenido, suscribo adjuntando copia de mi cédula de ciudadanía.
                </p>

                <br>

                <p align="center">
                        ___________________________
                </p>

                <p align="center">
                    FIRMA
                </p>

                <br>

                <p align="center">
                        ___________________________
                </p>

                <p align="center">
                    C.C.
                </p>

            </td>
        </tr>
    </table>

    <br><br>

<p style="font-size: 9px; color: #0a568c; text-align: center;">
    Oficina: José Mascote 1103 y Luque. Telfs: 2367856 - 2531488. fedeguayas.com.ec. email: fdg@telconet.net
    Casilla 836 Telegramas y Cables - FEDEGUAYAS. Guayaquil - Ecuador
</p>

</footer>

</body>
</html>
