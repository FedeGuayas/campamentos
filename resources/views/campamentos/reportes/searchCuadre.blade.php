{!! Form::open (['route' => 'admin.pagos.cuadre', 'method' => 'GET','role' => 'search','class'=>'form_datepicker' ])!!}

        <div class="input-field col s3 ">
            {!! Form::label('fecha','Fecha:') !!}
            {!! Form::date('fecha',$fecha,['class'=>'datepicker']) !!}
        </div>
        <div class="input-field col s3 ">
            {{Form::select('escenario',$escenarioSelect,$escenario,['id'=>'escenario']) }}
        </div>

        <div class="input-field col s3 ">
            {!! Form::button('Buscar<i class="fa fa-search left"></i>',['class'=>'btn', 'type'=>'submit']) !!}
        </div>
        {{--{!! Form::date('fecha',\Carbon\Carbon::now()) !!}--}}
{{--        {!! Form::date('fecha',$fecha,['class'=>'form-control', 'placeholder'=>'Selecione la fecha']) !!}--}}
{{--        {{Form::select('usuario',$usuarioSelect,$usuario,['class'=>'form-control']) }}--}}

{!! Form::close() !!}
