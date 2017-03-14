<h5 class="header teal-text text-darken-2">Alumnos</h5>
<div class="row">
    {{--Lista de alumnos --}}
    <div class="col s12 m6 l12">
        <div class="card sticky-action hoverable large">

            <div class="card-content">
                <table>
                    <thead>
                    <tr>
                        <th data-field="nombre_rep">Representante</th>
                        <th data-field="nombre_rep">Alumno</th>
                        <th data-field="cedula_rep">CI</th>
                        <th data-field="fecha_nac_rep">Fecha nac.</th>
                        <th data-field="fecha_nac_rep">Edad</th>
                        <th data-field="foto_rep">Foto</th>
                        <th data-field="accion_rep">Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (count($alumnos)>0)
                        @foreach($alumnos as $alumno)
                            <tr>
                                <td>
                                    {{$alumno->representante->persona->getNombreAttribute()}}
                                </td>
                                <td>
                                    {{$alumno->persona->getNombreAttribute()}}
                                </td>
                                <td>
                                    {{$alumno->persona->num_doc}}
                                </td>
                                <td>
                                    {{$alumno->persona->fecha_nac}}
                                </td>
                               <td> {{$alumno->getEdad($alumno->persona->fecha_nac)}}</td>
                                <td>
                                    @if (empty($alumno->foto))
                                        <img class=" activator circle" alt="Foto del Alumno"
                                             src="{{ asset('/img/camp/user-avatar-default.png')}}" style="max-width: 100px;">
                                    @else
                                        <img class="responsive-img img-thumbnail circle"
                                             src="{{ asset('/dist/img/alumnos/perfil/'.$alumno->foto)}}"
                                             style="max-width: 100px;">
                                    @endif
                                </td>
                                <td>
                                    {!! Form::button('<i class="fa fa-pencil" aria-hidden="true"></i>',['class'=>'btn-floating tooltipped waves-effect waves-light modal-trigger',  'data-target'=>"modal-edit-alumno-$alumno->id", 'data-position'=>'top', 'data-delay'=>'50', 'data-tooltip'=>'Editar']) !!}
                                        {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i>',['class'=>'btn-floating tooltipped waves-effect waves-light red darken-1','data-position'=>'top', 'data-delay'=>'50', 'data-tooltip'=>'Eliminar','value'=>$alumno->id,'onclick'=>'delete_alumno(this)']) !!}
                                </td>
                            </tr>
                            @include('online.users.profile.edit_alumno')
                        @endforeach
                    @endif
{{--                    <p>{{$msg_exist}}</p>--}}
                    </tbody>
                </table>
            </div>

            @if (count($alumnos)<1)
            {{--Crear Alumno--}}
            {{--<div class="card-reveal">--}}
                {{--<span class="card-title red-text text-darken-4"><i class="fa fa-times right" aria-hidden="true"></i></span>--}}
                {{--{!! Form::open(['route'=>'user.alumno.store', 'method'=>'POST','files'=>'true'])  !!}--}}
                {{--<div class="col s12">--}}
                    {{--<div class="row">--}}
                        {{--<div class="input-field col l4 m6 s12 ">--}}
                            {{--<i class="fa fa-user prefix"></i>--}}
                            {{--{!! Form::label('nombres','Nombres:*') !!}--}}
                            {{--{!! Form::text('nombres',$user->first_name,['class'=>'validate','required','style'=>'text-transform:uppercase']) !!}--}}
                        {{--</div>--}}
                        {{--<div class="input-field col l4 m6 s12">--}}
                            {{--{!! Form::label('apellidos','Apellidos:*') !!}--}}
                            {{--{!! Form::text('apellidos',$user->last_name,['class'=>'validate','required','style'=>'text-transform:uppercase']) !!}--}}
                        {{--</div>--}}

                        {{--<div class="input-field col l2 m4 s12">--}}
                            {{--{!! Form::select('tipo_doc', ['CEDULA' => 'CEDULA', 'PASAPORTE' => 'PASAPORTE'],null, ['id'=>'tipo_doc','required']) !!}--}}
                            {{--{!! Form::label('tipo_doc', 'Tipo doc:*') !!}--}}
                        {{--</div>--}}
                        {{--<div class="input-field col l2 m4 s12">--}}
                            {{--{!! Form::label('num_doc','Número:*') !!}--}}
                            {{--{!! Form::text('num_doc',null,['class'=>'validate','required']) !!}--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="row">--}}
                        {{--<div class="input-field col l2 m4 s12">--}}
                            {{--{!! Form::select('genero', ['MASCULINO' => 'MASCULINO', 'FEMENINO' => 'FEMENINO'],null, ['id'=>'genero','required']) !!}--}}
                            {{--{!! Form::label('genero','Género:') !!}--}}
                        {{--</div>--}}

                        {{--<div class="input-field col l4 m6 s12">--}}
                            {{--<i class="fa fa-envelope prefix"></i>--}}
                            {{--{!! Form::label('email','Correo:*') !!}--}}
                            {{--{!! Form::email('email',$user->email,['class'=>'validate','required']) !!}--}}
                        {{--</div>--}}

                        {{--<div class="input-field  col l3 m3 s6">--}}
                            {{--<i class="fa fa-phone prefix"></i>--}}
                            {{--{!! Form::text('telefono',null,['class'=>'validate','id'=>'telefono', 'required']) !!}--}}
                            {{--{!! Form::label('telefono','Teléfono1*:') !!}--}}
                        {{--</div>--}}
                        {{--<div class="input-field  col l3 m3 s6">--}}
                            {{--<i class="fa fa-phone prefix"></i>--}}
                            {{--{!! Form::text('phone',null,['class'=>'validate','id'=>'phone']) !!}--}}
                            {{--{!! Form::label('phone','Teléfono2:') !!}--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="row">--}}
                        {{--<div class="input-field  col l6 m7 s12">--}}
                            {{--<i class="fa fa-pencil prefix"></i>--}}
                            {{--{!! Form::textarea('direccion',null,['class'=>'materialize-textarea validate','id'=>'direccion','length'=>'255','required','style'=>'text-transform:uppercase']) !!}--}}
                            {{--{!! Form::label('direccion','Dirección*:') !!}--}}
                        {{--</div>--}}
                        {{--<div class="form-group col l2 m4 s6">--}}
                            {{--{!! Form::label('fecha','Fecha de Nacimiento:*',['class'=>'label-control']) !!}--}}
                            {{--{{  Form::date('fecha_nac',null,[ 'class'=>'validate','required']) }}--}}
                        {{--</div>--}}
                        {{--<div class="input-field col l4 m6 s12 ">--}}
                            {{--{!! Form::select('encuesta_id',$encuesta,null, ['id'=>'encuesta_id','placeholder'=>'Responda la encuesta ...']) !!}--}}
                            {{--{!! Form::label('encuesta_id', '¿Cómo nos conocio?:*') !!}--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="row">--}}
                        {{--<div class="file-field input-field  col l3 m6 s6">--}}
                            {{--<i class="fa  fa-2x fa-image prefix" aria-hidden="true"></i>--}}
                            {{--{!! Form::text('foto_ced','Fotocopia Cedula*',['class'=>'file-path validate']) !!}--}}
                            {{--{!! Form::file('foto_ced',['required']) !!}--}}
                        {{--</div>--}}
                        {{--<div class="file-field input-field  col l3 m6 s6">--}}
                            {{--<i class="fa fa-2x fa-image prefix" aria-hidden="true"></i>--}}
                            {{--{!! Form::text('foto','Foto Carnet*',['class'=>'file-path validate']) !!}--}}
                            {{--{!! Form::file('foto',['required']) !!}--}}
                        {{--</div>--}}
                        {{--<div class="col s6">--}}
                            {{--<div class="clearfix">--}}
                                {{--<div class="center-align">--}}
                                    {{--{!! Form::button('Crear<i class="fa fa-play right"></i>', ['class'=>'btn waves-effect waves-light','type'=>'submit']) !!}--}}
                                    {{--{!! Form::button('Cancelar<i class="fa fa-close right"></i>',['class'=>'btn waves-effect waves-light red darken-1','type' => 'reset']) !!}--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {!! Form::close() !!}

            {{--</div>--}}{{--./card-reveal--}}
                @endif
        </div>{{--./card sticky-action hoverable medium --}}

    </div>{{--Fin Crear Representantes --}}


</div>



