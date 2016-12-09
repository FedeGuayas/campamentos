{!! Form::open (['route' => 'admin.pagos.cuadre', 'method' => 'GET','role' => 'search' ])!!}
	<div class="form-inline">
        {{--{!! Form::date('fecha',\Carbon\Carbon::now()) !!}--}}
        {!! Form::date('fecha',$fecha,['class'=>'form-control', 'placeholder'=>'Selecione la fecha']) !!}
{{--        {{Form::select('usuario',$usuarioSelect,$usuario,['class'=>'form-control']) }}--}}
        {{Form::select('escenario',$escenarioSelect,$escenario,['class'=>'form-control']) }}
        {!! Form::submit('Buscar',['class'=>'btn btn-primary']) !!}

	</div>
{!! Form::close() !!}