@extends('layouts.admin.index')

@section('title', 'Crear Transporte')

@section('content')

    <div class="row">
        <div class="col l8 m12 s12">
            <div class="card-panel">
                <h5 class="header teal-text text-darken-2">Crear Transporte</h5>
                <div class="card-content ">

                    {!! Form::open(['route'=>'admin.transportes.store', 'method'=>'POST'])  !!}
                    <div class="col s12">

                        <div class="input-field col s12 ">
                            {!! Form::label('destino','Destino:') !!}
                            {!! Form::text('destino',null,['class'=>'validate']) !!}
                        </div>

                        <div class="input-field col l6 m6 s12">
                        {!! Form::select('escenarios', ['Esc1'=>'escenario1','Esc2'=>'esc2'],null, ['id'=>'roles_id','multiple']) !!}
                        {!! Form::label('escenarios', 'Escenarios:') !!}
                        </div>

                        <div class="input-field col s12 ">
                            <i class="fa fa-usd prefix"></i>
                            {!! Form::label('precio','Precio:') !!}
                            {!! Form::number('precio',null,['class'=>'precio validate']) !!}
                        </div>


                    </div>
                    {!! Form::button('Crear<i class="fa fa-play right"></i>', ['class'=>'btn waves-effect waves-light','type' => 'submit']) !!}
                    {!! Form::button('Cancelar<i class="fa fa-close right"></i>',['class'=>'btn waves-effect waves-light red darken-1','type' => 'reset']) !!}
                    <a href="{{ route('admin.roles.index') }}"  class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="Regresar">
                        {!! Form::button('<i class="fa fa-undo"></i>',['class'=>'btn waves-effect waves-light darken-1']) !!}
                    </a>

                    {!! Form::close() !!}


                </div><!--/.card content-->
            </div><!--/.card panel-->
        </div><!--/.col s12-->
    </div><!--/.row-->

@endsection

