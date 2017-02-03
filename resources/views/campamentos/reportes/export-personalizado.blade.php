{!! Form::open (['route' => 'admin.reports.exportPersonalizado','method' => 'GET', 'class'=>'form_datepicker' ])!!}
<div class="hidden">
    {{Form::select('modulo',$moduloSelect,$modulo,['id'=>'modulo']) }}
    {{Form::select('escenario',$escenarioSelect,$escenario,['id'=>'escenario']) }}
    {{Form::select('disciplina',$disciplinaSelect,$disciplina,['id'=>'disciplina']) }}
    {{Form::select('horario',$horarioSelect,$horario,['id'=>'horario']) }}
    {{Form::select('entrenador',$entrenadorSelect,$entrenador,['id'=>'entrenador']) }}
</div>
<div class="col s1">
    {!! Form::button('<i class="fa fa-file-excel-o fa-2x" ></i>',['class'=>'exportar btn-floating waves-effect waves-light teal tooltipped','data-position'=>'top', 'data-delay'=>'50','data-tooltip'=>'Exportar', 'type'=>'submit']) !!}
</div>
{!!form::close()!!}