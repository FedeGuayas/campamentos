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
                <th style="width: 160px; text-decoration: underline; ">REGISTRO # {{sprintf("%'.05d",$inscripcion->id)}}</th>
                <th style=" text-decoration: underline;">COMPROBANTE # {{$inscripcion->factura->id}}</th>
                <th style="width:200px; height: 20px"><img alt="LOGO" src="img/camp/fdg-logo.png" style="width: 200px; height: 100px; "/>
                </th>
            </tr>
            </thead>
        </table>
        <br><br><br>
        <p style="text-align: center;"><span>INSCRIPCION EN CAMPAMENTOS DEPORTIVOS FEDEGUAYAS</span></p>
    </div>
</header>

<main style="font-size: 10px;">

    <table align="center" border="0" cellpadding="5" cellspacing="0" style=" width: 700px; ">
        <tr>
            <th style="text-decoration: underline">DATOS DEL INSCRITO</th>
        </tr>
       <tr>
           <td>
               <table align="center" border="0" cellpadding="2" cellspacing="0" style=" width: 400px; ">
                   <tr>
                       <th  align="right" style="width: 130px;">ALUMNO:</th>
                       <td>{{$inscripcion->factura->representante->persona->apellidos.' '.$inscripcion->factura->representante->persona->nombres}}</td>
                   </tr>
                   <tr>
                       <th align="right">EDAD:</th>
                       <td>{{$inscripcion->factura->representante->getEdad($inscripcion->factura->representante->persona->fecha_nac)}}</td>
                   </tr>
                   <tr>
                       <th align="right">SEXO:</th>
                       <td>{{$inscripcion->factura->representante->persona->genero}}</td>
                   </tr>
                   <tr>
                       <th align="right">DIRECCION:</th>
                       <td>{{$inscripcion->factura->representante->persona->direccion}}</td>
                   </tr>
                   <tr>
                       <th align="right">TEEFONO:</th>
                       <td>{{$inscripcion->factura->representante->persona->telefono}}</td>
                   </tr>
                   <tr>
                       <th align="left">CORREO ELECTRONICO:</th>
                       <td>{{$inscripcion->factura->representante->persona->email}}</td>
                   </tr>
               </table>
           </td>
       </tr>
    </table>

    <br>

    <table align="center" border="0" cellpadding="5" cellspacing="0" style=" width: 700px; ">
        <tr>
            <th style="text-decoration: underline">DATOS DEL CURSO</th>
            <th style="text-decoration: underline">DATOS SOBRE LA INSCRIPCION</th>
        </tr>
        <tr>
            <td>
                <table align="center" border="0" cellpadding="2" cellspacing="0" style=" width: 400px;">
                    <tr>
                        <th align="right">MODULO:</th>
                        <td>{{$inscripcion->calendar->program->modulo->modulo}}</td>
                    </tr>
                    <tr>
                        <th align="right"  style="width: 130px;">ESCENARIO:</th>
                        <td>{{$inscripcion->calendar->program->escenario->escenario}}</td>
                    </tr>
                    <tr>
                        <th align="right">DISCIPLINA:</th>
                        <td>{{$inscripcion->calendar->program->disciplina->disciplina}}</td>
                    </tr>
                    <tr>
                        <th align="right">DIAS:</th>
                        <td>{{$inscripcion->calendar->dia->dia}}</td>
                    </tr>
                    <tr>
                        <th align="right">HORARIO:</th>
                        <td>{{$inscripcion->calendar->horario->start_time.'-' .$inscripcion->calendar->horario->end_time }}</td>
                    </tr>

                </table>
            </td>
            <td>
                <table align="center" border="0" cellpadding="2" cellspacing="0" style=" width: 400px;">
                    <tr>
                        <th align="right" >APLICA DESCUENTO:</th>
                        <td>
                            @if($inscripcion->factura->descuento==null || $inscripcion->factura->descuento==0)
                                NO
                            @else
                                SI
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th align="right" style="width: 130px;">TIPO DE INSCRIPCION:</th>
                        <td>
                            @if($inscripcion->factura->descuento==null || $inscripcion->factura->descuento==0)
                                INDIVIDUAL
                            @else
                                INSCRIPCION, {{$inscripcion->factura->descuentos->descripcion}}
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th align="right">FORMA DE PAGO:</th>
                        <td>{{$inscripcion->factura->pago->forma}}</td>
                    </tr>
                    <tr>
                        <th align="right">USUARIO:</th>
                        <td>{{$inscripcion->user->getNameAttribute()}}</td>
                    </tr>
                    <tr>
                        <th align="right">CANCELADO:</th>
                        <td>$ {{number_format($inscripcion->factura->total,2,'.',' ')}}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>



</main>

<footer style="font-size: 12px">
    <br>
    <table align="center" border="0" cellspacing="0" style="width:80%; font-style: italic; text-align : justify; ">
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

    <table align="center" border="1" cellpadding="10" cellspacing="10" style="width:90%; text-align : justify; ">
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
                    Nombre:<br>
                    CI:
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


