@extends('layouts.admin.index')

@section('title', 'Editar Encuesta')

@section('content')

    <div class="row">
        <div class="col l8 m12 s12">
            <div class="card-panel">
                <h5 class="header teal-text text-darken-2">Editar Encuesta</h5>
                <div class="card-content ">

                    {!! Form::model($encuesta,['route'=>['admin.encuestas.update',$encuesta->id], 'method'=>'PUT'])  !!}
                    <div class="col s12">

                            <div class="input-field col s12 ">
                                {!! Form::label('encuesta','Encuesta:*') !!}
                                {!! Form::text('encuesta',null,['class'=>'validate','style'=>'text-transform:uppercase']) !!}
                            </div>

                    </div>
                    {!! Form::button('Actualizar<i class="fa fa-play right"></i>', ['class'=>'btn waves-effect waves-light','type' => 'submit']) !!}
                    {!! Form::button('Cancelar<i class="fa fa-close right"></i>',['class'=>'btn waves-effect waves-light red darken-1','type' => 'reset']) !!}
                    <a href="{{ route('admin.encuestas.index') }}">
                        {!! Form::button('<i class="fa fa-undo"></i>',['class'=>'btn waves-effect waves-light darken-1']) !!}
                    </a>
                    {!! Form::close() !!}

                </div><!--/.card content-->
            </div><!--/.card panel-->
        </div><!--/.col s12-->
    </div><!--/.row-->

@endsection