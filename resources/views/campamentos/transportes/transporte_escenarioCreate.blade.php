@extends('layouts.admin.index')

@section('title', 'Transporte origen')

@section('content')

    <div class="row">
        <div class="col l8 m12 s12">
            <div class="card-panel">
                <h5 class="header teal-text text-darken-2">Transporte - Escenarios </h5>
                @include('alert.request')
                <div class="card-content ">

                    {!! Form::open(['route'=>'admin.set_escenario', 'method'=>'POST'])  !!}
                    {!! Form::hidden('transporte_id',$transporte->id) !!}
                    <div class="col s12">

                        <div class="input-field col l6 s12 ">
                            {!! Form::label('destino','Destino:') !!}
                            {!! Form::text('destino',$transporte->destino,['class'=>'validate', 'disabled']) !!}
                        </div>

                        <div class="input-field col l6 m6 s12">
                        {!! Form::select('escenario',$escenarios,null, ['id'=>'escenario_id', 'placeholde'=>'seleccione destino ...']) !!}
                        {!! Form::label('escenario', 'Escenarios origen:') !!}
                        </div>

                        <div class="input-field col l6 s12 ">
                            <i class="fa fa-usd prefix" aria-hidden="true"></i>
                            {!! Form::label('precio','Precio:') !!}
                            {!! Form::number('precio','0.00',['step' => '0.01','min' => '0.01','class'=>'validate', 'required']) !!}
                        </div>


                    </div>
                    {!! Form::button('Crear<i class="fa fa-play right"></i>', ['class'=>'btn waves-effect waves-light','type' => 'submit']) !!}
                    {!! Form::button('Cancelar<i class="fa fa-close right"></i>',['class'=>'btn waves-effect waves-light red darken-1','type' => 'reset']) !!}
                    <a href="{{ route('admin.transportes.index') }}"  class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="Regresar">
                        {!! Form::button('<i class="fa fa-undo"></i>',['class'=>'btn waves-effect waves-light darken-1']) !!}
                    </a>

                    {!! Form::close() !!}


                </div><!--/.card content-->
            </div><!--/.card panel-->
        </div><!--/.col s12-->
    </div><!--/.row-->

@endsection

