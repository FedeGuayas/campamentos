@extends('layouts.admin.index')

@section('title', 'Editar Representante')

@section('content')

    <div class="row">
        <div class="col s12">
            <div class="card-panel">
                <h5 class="header teal-text text-darken-2">Editar Representante</h5>
                <div class="card-content ">

                    @include('alert.request')
                    {!! Form::model($representante,['route'=>['admin.representantes.update',$representante->id], 'method'=>'PUT', 'files'=>'true']) !!}
                    <div class="col s12">

                        <div class="row">
                            <div class="input-field col m5 s12 ">
                                <i class="fa fa-user prefix"></i>
                                {!! Form::label('nombres','Nombres:*') !!}
                                {!! Form::text('nombres',$representante->persona->nombres,['class'=>'validate','required','style'=>'text-transform:uppercase']) !!}
                            </div>
                            <div class="input-field col m5 s12">
                                {!! Form::label('apellidos','Apellidos:*') !!}
                                {!! Form::text('apellidos',$representante->persona->apellidos,['class'=>'validate','required','style'=>'text-transform:uppercase']) !!}
                            </div>

                            <div class="input-field col m2 s12">
                                {!! Form::select('tipo_doc', ['CEDULA' => 'CEDULA', 'PASAPORTE' => 'PASAPORTE'],$representante->persona->tipo_doc, ['id'=>'tipo_doc']) !!}
                                {!! Form::label('tipo_doc', 'Tipo doc:*') !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col m3 s6">
                                {!! Form::label('num_doc','Número del documento:*') !!}
                                {!! Form::text('num_doc',$representante->persona->num_doc,['class'=>'validate','required','onkeypress'=>"if (this.value.length > 9) {return false}"]) !!}
                            </div>
                            <div class="input-field col m3 s6">
                                {!! Form::select('genero', ['MASCULINO' => 'MASCULINO', 'FEMENINO' => 'FEMENINO'],$representante->persona->genero, ['id'=>'genero','required']) !!}
                                {!! Form::label('genero','Género:') !!}
                            </div>
                            <div class="input-field  col m3 s6">
                                <i class="fa fa-phone prefix"></i>
                                {!! Form::text('telefono',$representante->persona->telefono,['class'=>'validate','id'=>'telefono', 'required']) !!}
                                {!! Form::label('telefono','Teléfono1*:') !!}
                            </div>
                            <div class="input-field  col m3 s6">
                                <i class="fa fa-phone prefix"></i>
                                {!! Form::text('phone',$representante->persona->phone,['class'=>'validate','id'=>'phone']) !!}
                                {!! Form::label('phone','Teléfono2:') !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col m4 s6">
                                <i class="fa fa-envelope prefix"></i>
                                {!! Form::label('email','Correo:*') !!}
                                {!! Form::email('email',$representante->persona->email,['class'=>'validate','required']) !!}
                            </div>
                            <div class="form-group col m2 s6">
                                {!! Form::label('fecha','Fecha de Nacimiento:',['class'=>'label-control']) !!}
                                {{  Form::date('fecha_nac',$representante->persona->fecha_nac,[ 'class'=>'validate','required']) }}
                            </div>

                            <div class="file-field input-field  col m3 s6">
                                <div class="btn">
                                    <span><i class="fa fa fa-file-image-o prefix" aria-hidden="true"></i></span>
                                    {!! Form::file('foto_ced') !!}
                                </div>
                                <div class="file-path-wrapper">
                                    {!! Form::text('foto_ced',null,['class'=>'file-path validate','placeholder'=>'Foto-Cedula']) !!}
                                </div>
                                @if (($representante->foto_ced)!="")
                                    <img src="{{ asset('dist/img/representantes/cedula/'.$representante->foto_ced)}}"
                                         style='max-width: 150px' class="img-thumbnail">
                                @endif
                            </div>
                            <div class="file-field input-field  col m3 s6">
                                <div class="btn">
                                    <span><i class="fa fa fa-file-image-o prefix" aria-hidden="true"></i></span>
                                    {!! Form::file('foto') !!}
                                </div>
                                <div class="file-path-wrapper">
                                    {!! Form::text('foto',null,['class'=>'file-path validate','placeholder'=>'Foto']) !!}
                                </div>
                                @if (($representante->foto)!="")
                                    <img src="{{ asset('dist/img/representantes/perfil/'.$representante->foto)}}"
                                         style='max-width: 150px' class="img-thumbnail">
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col m3 s12">
                                {!! Form::select('provincia_id',$list_provincias,null,['placeholder'=>'Seleccione provincia...','title'=>'Seleccione la provincia','id'=>'provincia_id']) !!}
                                {!! Form::label('provincia_id','Provincia:') !!}
                            </div>
                            <div class="input-field col m3 s12">
                                {!! Form::select('canton_id',[],null,['placeholder'=>'Seleccione el cantón','title'=>'Seleccione el cantón','id'=>'canton_id']) !!}
                                {!! Form::label('canton_id','Canton:') !!}
                            </div>
                            <div class="input-field col m3 s12">
                                {!! Form::select('parroquia_id',[],null,['placeholder'=>'Seleccione la parroquia','title'=>'Seleccione la parroquia','id'=>'parroquia_id']) !!}
                                {!! Form::label('parroquia_id','Parroquia:') !!}
                            </div>
                        </div>

                        <div class="input-field  col m6 s12">
                            <i class="fa fa-pencil prefix"></i>
                            {!! Form::textarea('direccion',$representante->persona->direccion,['class'=>'materialize-textarea validate','id'=>'direccion','length'=>'255','required','style'=>'text-transform:uppercase']) !!}
                            {!! Form::label('direccion','Dirección:') !!}
                        </div>


                    </div>

                    {!! Form::button('Actualizar<i class="fa fa-play right"></i>', ['class'=>'btn waves-effect waves-light','type' => 'submit']) !!}
                    {!! Form::button('Cancelar<i class="fa fa-close right"></i>',['class'=>'btn waves-effect waves-light red darken-1','type' => 'reset']) !!}
                    <a href="{{ route('admin.representantes.index') }}">
                        {!! Form::button('<i class="fa fa-undo"></i>',['class'=>'btn waves-effect waves-light darken-1']) !!}
                    </a>
                    {!! Form::close() !!}

                </div><!--/.card content-->
            </div><!--/.card panel-->
        </div><!--/.col s12-->
    </div><!--/.row-->

@endsection


@section('scripts')
    <script>
        var url_getCanton = "{{route('getCanton',':ID_Provincia')}}";
        var url_getParroquia = "{{route('getParroquia',':ID_Canton')}}";
    </script>
    <script src="{{ asset("js/dropdown-province.js") }}" type="text/javascript"></script>
@endsection