@extends('layouts.admin.index')

@section('title', 'Editar Representante')

@section('content')

    <div class="row">
        <div class="col l10 m6 s12">
            <div class="card-panel">
                <h5 class="header teal-text text-darken-2">Editar Representante</h5>
                <div class="card-content ">

                    @include('alert.request')
                    {!! Form::model($representante,['route'=>['admin.representantes.update',$representante->id], 'method'=>'PUT', 'files'=>'true']) !!}
                    <div class="col s12">

                        <div class="input-field col l6 m6 s12 ">
                            <i class="fa fa-user prefix"></i>
                            {!! Form::label('nombres','Nombres:*') !!}
                            {!! Form::text('nombres',$representante->persona->nombres,['class'=>'validate','required']) !!}
                        </div>
                        <div class="input-field col l6 m6 s12">
                            {!! Form::label('apellidos','Apellidos:*') !!}
                            {!! Form::text('apellidos',$representante->persona->apellidos,['class'=>'validate','required']) !!}
                        </div>

                        <div class="input-field col l4 m4 s12">
                            {!! Form::select('tipo_doc', ['Cedula' => 'Cedula', 'Pasaporte' => 'Pasaporte'],$representante->persona->tipo_doc, ['id'=>'tipo_doc']) !!}
                            {!! Form::label('tipo_doc', 'Tipo doc:*') !!}
                        </div>
                        <div class="input-field col l4 m4 s12">
                            {!! Form::label('num_doc','Número del documento:*') !!}
                            {!! Form::text('num_doc',$representante->persona->num_doc,['class'=>'validate','required']) !!}
                        </div>

                        <div class="input-field col l4 m4 s12">
                            {!! Form::select('genero', ['Masculino' => 'Masculino', 'Femenino' => 'Femenino'],$representante->persona->genero, ['id'=>'genero']) !!}
                            {!! Form::label('genero','Género:') !!}
                        </div>
                        {{--<div class="form-group col l6 m6 s12">--}}
                            {{--{!! Form::label('fecha','Fecha de Nacimiento:',['class'=>'label-control']) !!}--}}
                            {{--{{  Form::date('fecha_nac',$representante->persona->fecha_nac,[ 'class'=>'validate','required']) }}--}}
                        {{--</div>--}}

                        <div class="input-field col l6 m6 s12">
                            <i class="fa fa-envelope prefix"></i>
                            {!! Form::label('email','Correo:*') !!}
                            {!! Form::email('email',$representante->persona->email,['class'=>'validate']) !!}

                        </div>

                        <div class="input-field  col l6 m6 s12">
                            <i class="fa fa-pencil prefix"></i>
                            {!! Form::textarea('direccion',$representante->persona->direccion,['class'=>'materialize-textarea validate','id'=>'direccion','length'=>'255']) !!}
                            {!! Form::label('direccion','Dirección:') !!}
                        </div>

                        <div class="input-field  col l6 m6 s12">
                            <i class="fa fa-phone prefix"></i>
                            {!! Form::text('phone',null,['class'=>'validate','id'=>'phone']) !!}
                            {!! Form::label('phone','Teléfono1:*') !!}
                        </div>
                        <div class="input-field  col l6 m6 s12">
                            <i class="fa fa-phone prefix"></i>
                            {!! Form::text('telefono',$representante->persona->telefono,['class'=>'validate','id'=>'telefono']) !!}
                            {!! Form::label('telefono','Teléfono2:') !!}
                        </div>

                        <div class="file-field input-field  col l6 m6 s12">
                            <div class="btn">
                                <span><i class="fa fa fa-file-image-o prefix" aria-hidden="true"></i></span>
                                {!! Form::file('foto_ced') !!}
                            </div>
                            <div class="file-path-wrapper">
                                {!! Form::text('foto_ced',null,['class'=>'file-path validate','placeholder'=>'Foto-Cedula']) !!}
                            </div>
                            @if (($representante->foto_ced)!="")
                                <img src="{{ asset('dist/img/representantes/cedula/'.$representante->foto_ced)}}" style='max-width: 150px' class="img-thumbnail">
                            @endif
                        </div>
                        <div class="file-field input-field  col l6 m6 s12">
                            <div class="btn">
                                <span><i class="fa fa fa-file-image-o prefix" aria-hidden="true"></i></span>
                                {!! Form::file('foto') !!}
                            </div>
                            <div class="file-path-wrapper">
                                {!! Form::text('foto',null,['class'=>'file-path validate','placeholder'=>'Foto']) !!}
                            </div>
                            @if (($representante->foto)!="")
                                <img src="{{ asset('dist/img/representantes/perfil/'.$representante->foto)}}" style='max-width: 150px' class="img-thumbnail">
                            @endif
                        </div>

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