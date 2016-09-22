@extends('layouts.admin.index')

@section('title', 'Crear Permisos')

@section('content')
    <div class="row">
        <div class="col l6 m8 s12">
            <div class="card-panel">
                <h5 class="header teal-text text-darken-2">Crear Permisos</h5>
                <div class="card-content">
                    {!! Form::open(['route'=>'admin.permissions.store', 'method'=>'POST'])  !!}

                    <div class="input-field col l12 m4 s12 ">
                        {!! Form::label('name','Permiso nombre:*') !!}
                        {!! Form::text('name',null,['class'=>'validate']) !!}
                    </div>

                    <div class="input-field col l12 m4 s12">
                        {!! Form::label('display_name','Nombre a mostrar:*') !!}
                        {!! Form::text('display_name',null,['class'=>'validate']) !!}
                    </div>

                    <div class="input-field col l12 s12">
                        <i class="material-icons prefix">mode_edit</i>
                        {!! Form::textarea('description',null,['class'=>'materialize-textarea validate','id'=>'description','length'=>'120']) !!}
                        {!! Form::label('description','Descripción...') !!}
                    </div>
                    {!! Form::button('Crear<i class="material-icons right">touch_app</i>', ['class'=>'btn waves-effect waves-light','type' => 'submit']) !!}
                    {!! Form::button('Cancelar<i class="material-icons right">cancel</i>',['class'=>'btn waves-effect waves-light red darken-1','type' => 'reset']) !!}
                    {!! Form::close() !!}
                </div><!--/.card-content-->
            </div><!--/.card-panel-->
        </div><!--/.col l6 m8 s12-->
    </div> <!--/.row-->

    <script>

        $(document).ready(function() {
        $('select').material_select();
        });


    </script>

@endsection

