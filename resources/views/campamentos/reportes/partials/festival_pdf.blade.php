<div>
    <div style="width:200px; height: 20px;">
        <img alt="LOGO" src="img/camp/fdg-logo.png"
             style="width: 200px; height: 80px; position: absolute; top:  15px; left: 15px;"/>
    </div>
    <div style="text-align: center;">
        <p>CAMPAMENTOS DEPORTIVOS
        <p>FEDEGUAYAS</p>
        <p>II FESTIVAL DE NATACIÓN</p>
        <p>
            RECIBO DE INSCRIPCIÓN NO:
            <b>
                @if(count($inscripcion->register)>0)
                    {{sprintf("%'.04d",$inscripcion->register->num_registro)}}
                @else
                    {{sprintf("%'.04d",$inscripcion->id)}}
                @endif
            </b>
        </p>
    </div>
</div>

<div>

    <table align="center" border="0" cellpadding="2" cellspacing="0" style=" width: 80%; font-size: 12px;">
        <tr>
            <th align="left" style="text-decoration: underline; width: 350px;">DATOS DEL INSCRIPCIÓN</th>
            <th align="left" style="text-decoration: underline;"></th>
        </tr>
        <tr>
            <td>
                <table align="left" border="0" cellpadding="0" cellspacing="0" style=" width: 100%;">
                    <tr>
                        <th align="left" style="width: 80px;">Usuario:</th>
                        <td style="width: 500px;">
                            @if ($inscripcion->alumno_id == 0)
                                {{$inscripcion->factura->representante->persona->getNombreAttribute()}}
                            @else
                                {{$inscripcion->alumno->persona->getNombreAttribute()}}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th align="left">Edad:</th>
                        <td>
                            @if ($inscripcion->alumno_id == 0)
                                {{$inscripcion->factura->representante->getEdad($inscripcion->factura->representante->persona->fecha_nac)}}
                            @else
                                {{$inscripcion->alumno->getEdad($inscripcion->alumno->persona->fecha_nac)}}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th align="left">Cantón:</th>
                        <td>
                            {{--adulto--}}
                            @if ($inscripcion->alumno_id == 0)
                                {{--canton definido--}}
                                @if(!is_null($inscripcion->factura->representante->persona->parroquia))
                                    {{$inscripcion->factura->representante->persona->parroquia->canton->canton}}
                                @else
                                    -
                                @endif
                                {{--menor--}}
                            @else
                                {{--canton definido--}}
                                @if(!is_null($inscripcion->alumno->persona->parroquia))
                                    {{$inscripcion->alumno->persona->parroquia->canton->canton}}
                                @else
                                    -
                                @endif
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th align="left" style="width: 130px;">Fecha de Evento:</th>
                        <td>{{$fecha_evento}}</td>

                    </tr>
                    <tr>
                        <th align="left">Lugar del evento:</th>
                        <td>{{$inscripcion->calendar->program->escenario->escenario}}</td>
                    </tr>
                    <tr>
                        <th align="left">Hora:</th>
                        <td>{{date_create($inscripcion->calendar->horario->start_time)->format('H:i').'-' .date_create($inscripcion->calendar->horario->end_time)->format('H:i') }}</td>
                    </tr>
                    <tr>
                        <th align="left">Valor:</th>
                        <td>$ {{number_format($inscripcion->factura->total,2,'.',' ')}}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>

<br><br>

<div class="limpia_float content">
    <table align="center" border="0" cellpadding="2" cellspacing="0" style=" width: 80%; font-size: 12px;">
        <tr>
            <td colspan="2">
                <p class="text-info">Nota: La presentación de este recibo es indispensable para el día del
                    evento.</p>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>F.___________________________</td>
            <td>F.___________________________</td>
        </tr>
        <tr>
            <td>
                Firma del Receptor
            </td>
            <td>
                Representante
            </td>
        </tr>
        <tr>
            <td>{{ $inscripcion->user->getNameAttribute()}}</td>
            <td>
                {{$inscripcion->factura->representante->persona->getNameAttribute()}}
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td> CI: {{$inscripcion->factura->representante->persona->num_doc}}</td>
        </tr>
    </table>
</div>
