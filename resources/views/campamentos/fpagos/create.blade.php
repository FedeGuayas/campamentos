@extends('layouts.admin.index')

@section('title', 'Forma Pago')

@section('content')

    <div class="row">
        <div class="col l8 m12 s12">
            <div class="card-panel">
                <h5 class="header teal-text text-darken-2">Crear Forma de Pago</h5>
                <div class="card-content ">

                    {!! Form::open(['route'=>'admin.fpagos.store', 'method'=>'POST'])  !!}
                    <div class="col s12">

                        <div class="input-field col s12 ">
                            <i class="fa fa-money prefix" aria-hidden="true"></i>
                            {!! Form::label('forma','Forma de Pago:*') !!}
                            {!! Form::text('forma',null,['class'=>'validate','required','style'=>'text-transform:uppercase']) !!}
                        </div>
                        <div class="input-field col s12 ">
                            <i class="fa fa-pencil prefix"></i>
                            {!! Form::textarea('descripcion',null,['class'=>'materialize-textarea validate','style'=>'text-transform:uppercase','id'=>'direccion','length'=>'100']) !!}
                            {!! Form::label('descripcion','Descripción:') !!}
                        </div>

                    </div>
                        {!! Form::button('Crear<i class="fa fa-play right"></i>', ['class'=>'btn waves-effect waves-light','type' => 'submit']) !!}
                        {!! Form::button('Cancelar<i class="fa fa-close right"></i>',['class'=>'btn waves-effect waves-light red darken-1','type' => 'reset']) !!}
                        <a href="{{ route('admin.fpagos.index') }}"  class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="Regresar">
                            {!! Form::button('<i class="fa fa-undo"></i>',['class'=>'btn waves-effect waves-light darken-1']) !!}
                        </a>
                    {!! Form::close() !!}

                </div><!--/.card content-->
            </div><!--/.card panel-->
        </div><!--/.col s12-->
    </div><!--/.row-->

@endsection

