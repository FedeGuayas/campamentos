{!! Form::open (['route' => 'admin.reports.exportPersonalizado','method' => 'GET', 'class'=>'form_datepicker' ])!!}
<div class="hidden">
    <div class="input-field col s3 ">
        {{Form::select('modulo',$moduloSelect,$modulo,['id'=>'modulo']) }}
    </div>
    <div class="input-field col s3 ">
        {{Form::select('escenario',$escenarioSelect,$escenario,['id'=>'escenario']) }}
    </div>

    <div class="input-field col s3 ">
        {{Form::select('disciplina',$disciplinaSelect,$disciplina,['id'=>'disciplina']) }}
    </div>
    <div class="input-field col s3 ">
        {{Form::select('horario',$horarioSelect,$horario,['id'=>'horario']) }}
    </div>
    <div class="input-field col s3 ">
        {{Form::select('entrenador',$entrenadorSelect,$entrenador,['id'=>'entrenador']) }}
    </div>
    {{--<div class="input-field col s3 ">--}}
    {{--{!! Form::select('sexo', ['MASCULINO' => 'MASCULINO', 'FEMENINO' => 'FEMENINO'],'null', ['placeholder' => 'Sexo...','id'=>'sexo']) !!}--}}
    {{--</div>--}}


    <div class="input-field col s2 ">
        {!! Form::label('start','Desde:') !!}
        {!! Form::date('start',$start,['class'=>'datepicker']) !!}
    </div>
    <div class="input-field col s2 ">
        {!! Form::label('end','Hasta:') !!}
        {!! Form::date('end',$end,['class'=>'datepicker']) !!}
    </div>

</div>
<div class="col s2 pull-right ">
    {!! Form::button('Exportar <i class="fa fa-file-excel-o fa-2x" ></i>',['class'=>'btn exportar btn-xs waves-effect waves-light teal darken-1 tooltipped','data-position'=>'top', 'data-delay'=>'50','data-tooltip'=>'Exportar', 'type'=>'submit']) !!}
</div>
{!!form::close()!!}