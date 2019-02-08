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
        <b>Registro # {{sprintf("%'.05d",$matricula->id)}}</b>
    </div>
    <div style="width:200px; height: 20px;">
        <img alt="LOGO" src="img/camp/fdg-logo.png"
             style="width: 200px; height: 80px; position: absolute; top:  15px; right: 15px;"/>
    </div>
    <br><br>
    <div style="text-align: center; position: relative">
        <p>
            <span><b>MODULO:</b></span> {{$matricula->inscripcion->calendar->program->modulo->modulo}}. <span><b> COMPROBANTE# </b></span>{{$matricula->factura_id}}
        </p>
        <p>
            <span>
                <b>
                    PAGO DE MATRICULA/MEMBRESIA EN CAMPAMENTOS DEPORTIVOS FEDEGUAYAS
                </b>
            </span>
        </p>
    </div>
</header>

<div class="limpia_float content">
    <table align="center" border="0" cellpadding="0" cellspacing="0" style=" width: 720px; font-size: 11px;">
        <tr>
            <th align="left" style="text-decoration: underline">DATOS DEL REPRESENTANTE / ALUMNO</th>
        </tr>
        <tr>
            <td>
                <table align="center" border="0" cellpadding="0" cellspacing="0"
                       style=" width: 400px; font-size: 12px; ">
                    <tr>
                        <th align="left" style="width: 130px;">CLIENTE:</th>
                        <td>{{$matricula->factura->representante->persona->apellidos.' '.$matricula->factura->representante->persona->nombres}}</td>
                    </tr>
                    <tr>
                        <th align="left">EDAD:</th>
                        <td>{{$matricula->factura->representante->getEdad($matricula->factura->representante->persona->fecha_nac)}}</td>
                    </tr>
                    <tr>
                        <th align="left">SEXO:</th>
                        <td>{{$matricula->factura->representante->persona->genero}}</td>
                    </tr>
                    <tr>
                        <th align="left">DIRECCION:</th>
                        <td>{{$matricula->factura->representante->persona->direccion}}</td>
                    </tr>
                    <tr>
                        <th align="left">TEEFONO:</th>
                        <td>{{$matricula->factura->representante->persona->telefono}}</td>
                    </tr>
                    <tr>
                        <th align="left">CORREO:</th>
                        <td>{{$matricula->factura->representante->persona->email}}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br>
    <table align="center" border="0" cellpadding="0" cellspacing="0" style=" width: 720px; font-size: 11px; ">
        <tr>
            <th align="left" style="text-decoration: underline; width: 350px;">DATOS DEL CURSO</th>
            <th align="left" style="text-decoration: underline">DATOS SOBRE LA INSCRIPCION</th>
        </tr>
        <tr>
            <td>
                <table align="center" border="0" cellpadding="0" cellspacing="0" style=" width: 100%;">
                    <tr>
                        <th align="left" style="width: 100px;">ESCENARIO:</th>
                        <td>{{$matricula->inscripcion->calendar->program->escenario->escenario}}</td>
                    </tr>
                    <tr>
                        <th align="left">DISCIPLINA:</th>
                        <td>{{$matricula->inscripcion->calendar->program->disciplina->disciplina}}</td>
                    </tr>
                    <tr>
                        <th align="left">DIAS:</th>
                        <td>{{$matricula->inscripcion->calendar->dia->dia}}</td>
                    </tr>
                    <tr>
                        <th align="left">HORARIO:</th>
                        <td>{{$matricula->inscripcion->calendar->horario->start_time.'-' .$matricula->inscripcion->calendar->horario->end_time }}</td>
                    </tr>
                </table>
            </td>
            <td>
                <table align="center" border="0" cellpadding="0" cellspacing="0" style=" width: 349px;">
                    <tr>
                        <th align="left">CONCEPTO:</th>
                        <td>
                            PAGO DE MATRICULA
                        </td>
                    </tr>

                    <tr>
                        <th align="left">FORMA DE PAGO:</th>
                        <td>{{$matricula->inscripcion->factura->pago->forma}}</td>
                    </tr>
                    <tr>
                        <th align="left">USUARIO:</th>
                        <td>{{$matricula->inscripcion->user->getNameAttribute()}}</td>
                    </tr>
                    <tr>
                        <th align="left">CANCELADO:</th>
                        <td>$ {{number_format($matricula->factura->total,2,'.',' ')}}</td>
                    </tr>
                    <tr>
                        <th align="left" style="width: 130px;">FECHA:</th>
                        <td>{{$matricula->created_at}}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>


<hr>

<div>
    <table align="left" border="0" cellpadding="5" cellspacing="0"
           style="position: absolute; width:60%; text-align : justify; font-size: 11px; margin-left: 30px;  top: 150px">
        <tr>
            <td>

                <p align="center">
                    ___________________________
                </p>

                <p align="center" style="font-size: 10px;">
                    FIRMA <br>
                    Nombre: {{$matricula->factura->representante->persona->getNombreAttribute()}}<br>
                    CI: {{$matricula->factura->representante->persona->num_doc}}
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
                    Oficina: José Mascote 1103 y Luque. Telfs: 2367856 - 2531488. fedeguayas.com.ec <br>
                    Casilla 836 Telegramas y Cables - FEDEGUAYAS. Guayaquil - Ecuador
                </p>
            </td>
        </tr>
    </table>
</footer>
</body>
</html>
