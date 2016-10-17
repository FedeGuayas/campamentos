@extends('layouts.admin.index')

@section('title', 'Crear Alumno')

@section('content')

    <div class="row">
        <div class="col l8 m12 s12">
            <div class="card-panel">
                <h5 class="header teal-text text-darken-2">Crear Alumno</h5>
                <div class="card-content ">
                    @include('alert.request')
                    {!! Form::open(['route'=>'admin.alumnos.store', 'method'=>'POST','files'=>'true'])  !!}
                    <div class="col s12">

                        <div class="input-field col l6 m6 s12 ">
                            <i class="fa fa-user prefix"></i>
                            {!! Form::label('nombres','Nombres:*') !!}
                            {!! Form::text('nombres',null,['class'=>'validate','required']) !!}
                        </div>
                        <div class="input-field col l6 m6 s12">
                            {!! Form::label('apellidos','Apellidos:*') !!}
                            {!! Form::text('apellidos',null,['class'=>'validate','required']) !!}
                        </div>


                        <div class="input-field col l6 m6 s12">
                        {!! Form::select('tipo_doc', ['Cedula' => 'Cedula', 'Pasaporte' => 'Pasaporte', 'NoDoc' => 'NoDoc'],null, ['id'=>'tipo_doc']) !!}
                        {!! Form::label('tipo_doc', 'Tipo doc:*') !!}
                        </div>
                        <div class="input-field col l6 m6 s12">
                            {!! Form::label('num_doc','Número del documento:*') !!}
                            {!! Form::text('num_doc',null,['class'=>'validate','required']) !!}
                        </div>

                        <div class="input-field col l6 m6 s12">
                            {!! Form::select('genero', ['Masculino' => 'Masculino', 'Femenino' => 'Femenino'],null, ['id'=>'genero']) !!}
                            {!! Form::label('genero','Género:') !!}
                        </div>
                        <div class="form-group col l6 m6 s12">
                            {!! Form::label('fecha','Fecha de Nacimiento:',['class'=>'label-control']) !!}
                            {{  Form::date('fecha_nac',null,[ 'class'=>'validate','required']) }}
                        </div>

                        <div class="input-field col l12 m6 s12">
                            <i class="fa fa-envelope prefix"></i>
                            {!! Form::label('email','Correo:*') !!}
                            {!! Form::email('email',null,['class'=>'validate']) !!}

                        </div>

                        <div class="input-field  col l12 m6 s12">
                            <i class="fa fa-pencil prefix"></i>
                            {!! Form::textarea('direccion',null,['class'=>'materialize-textarea validate','id'=>'direccion','length'=>'255']) !!}
                            {!! Form::label('direccion','Dirección:') !!}
                        </div>

                        <div class="input-field  col l6 m6 s12">
                            <i class="fa fa-phone prefix"></i>
                            {!! Form::text('telefono',null,['class'=>'validate','id'=>'telefono']) !!}
                            {!! Form::label('telefono','Teléfono1:*') !!}
                        </div>
                        <div class="input-field col l6 m6 s12">
                            {!! Form::select('discapacitado', ['NO' => 'No','SI' => 'Si' ],null, ['id'=>'discapacitado','placeholder'=>'Seleccione ...']) !!}
                            {!! Form::label('discapacitado','Discapacitado?:') !!}
                        </div>

                        <div class="file-field input-field  col l6 m6 s12">
                            <div class="btn">
                                <span><i class="fa fa fa-file-image-o prefix" aria-hidden="true"></i></span>
                                {!! Form::file('foto_ced') !!}
                            </div>
                            <div class="file-path-wrapper">
                                {!! Form::text('foto_ced',null,['class'=>'file-path validate','placeholder'=>'Foto-Cedula']) !!}
                            </div>
                        </div>
                        <div class="file-field input-field  col l6 m6 s12">
                            <div class="btn">
                                <span><i class="fa fa fa-file-image-o prefix" aria-hidden="true"></i></span>
                                {!! Form::file('foto') !!}
                            </div>
                            <div class="file-path-wrapper">
                                {!! Form::text('foto',null,['class'=>'file-path validate','placeholder'=>'Foto']) !!}
                            </div>
                        </div>

                     </div>
                </div>
                    {!! Form::button('Crear<i class="fa fa-play right"></i>', ['class'=>'btn waves-effect waves-light','type' => 'submit']) !!}
                    {!! Form::button('Cancelar<i class="fa fa-close right"></i>',['class'=>'btn waves-effect waves-light red darken-1','type' => 'reset']) !!}
                    <a href="{{ route('admin.alumnos.index') }}" class="tooltipped" data-position="top" data-delay="50" data-tooltip="Regresar">
                        {!! Form::button('<i class="fa fa-undo"></i>',['class'=>'btn waves-effect waves-light darken-1']) !!}
                    </a>
                    {!! Form::close() !!}

                </div><!--/.card content-->
            </div><!--/.card panel-->
        </div><!--/.col s12-->
    </div><!--/.row-->

@endsection

