@extends('layouts.admin.index')

@section('title','Representantes')


@section('content')

<div class="row">
    <div class="col l6 col m6 col s12">
        <h3>Importar Personas</h3>
        @include('alert.request')
        @include('alert.success')
    </div>
</div>
{!! Form::open (array('route' => 'persons.store', 'method'=>'POST','files'=>'true'))!!}
{{Form::token()}}
<div class="row">
    <div class="col l6 col m6 col s12">
        <div class="form-group">
            {!! Form::label('Cargar Excel de Personas:') !!}
            {{  Form::file('persons',['class' => 'form-control']) }}
        </div>
        {!! Form::button('Importar<i class="fa fa-file-image-o right"></i>', ['class'=>'btn waves-effect waves-light','id'=>'import_persons','type' => 'submit']) !!}
        {!! Form::button('Cancelar<i class="fa fa-close right"></i>',['class'=>'btn waves-effect waves-light orange darken-2','type' => 'reset']) !!}
        <a href="{{ route('persons.truncate') }}" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="Vaciar Tabla">
            {!! Form::button('<i class="fa fa-trash"></i>',['class'=>'btn waves-effect waves-light  red darken-3']) !!}
        </a>
    </div>

</div>

{!! Form::close() !!}

@endsection