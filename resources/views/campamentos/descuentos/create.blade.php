@extends('layouts.admin.index')

@section('title', 'Tipo descuento')

@section('content')

    <div class="row">
        <div class="col l8 m12 s12">
            @include('alert.success')
            <div class="card-panel">
                <h5 class="header teal-text text-darken-2">Crear descuento</h5>
                <div class="card-content ">

                    {!! Form::open(['route'=>'admin.tipo_descuentos.store', 'method'=>'POST'])  !!}
                    <div class="col s12">

                        <div class="input-field col s12 ">
                            <div class="input-field col s8 ">
                                {!! Form::label('nombre','Nombre Descuento: *') !!}
                                {!! Form::text('nombre',null,['class'=>'validate','style'=>'text-transform:uppercase']) !!}

                            </div>
                        </div>
                        <div class="input-field col s12 ">
                            <div class="input-field col s6 ">
                                {!! Form::label('porciento','Porciento (%): *') !!}
                                {!! Form::number('porciento',null,['step' => '1','min' => '1','max'=>'100','class'=>'validate','placeholder'=>'%']) !!}
                            </div>
                        </div>

                        <div class="input-field col s12 ">
                            {!! Form::textarea('descripcion',null,['class'=>'materialize-textarea validate','style'=>'text-transform:uppercase','id'=>'descripcion','length'=>'100']) !!}
                            {!! Form::label('descripcion','Descripción:') !!}
                        </div>

                    </div>
                    {!! Form::button('Crear<i class="fa fa-play right"></i>', ['class'=>'btn waves-effect waves-light','type' => 'submit']) !!}
                    {!! Form::button('Cancelar<i class="fa fa-close right"></i>',['class'=>'btn waves-effect waves-light red darken-1','type' => 'reset']) !!}
                    <a href="{{ route('admin.tipo_descuentos.index') }}"  class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="Regresar">
                        {!! Form::button('<i class="fa fa-undo"></i>',['class'=>'btn waves-effect waves-light darken-1']) !!}
                    </a>
                    {!! Form::close() !!}

                </div><!--/.card content-->
            </div><!--/.card panel-->
        </div><!--/.col s12-->
    </div><!--/.row-->

@endsection

