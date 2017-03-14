{!! Form::open (['route' => 'admin.reports.export-credenciales','method' => 'GET', 'target'=>'_blank'])!!}
<div class="hidden">
        {!! Form::date('start',$start,['class'=>'datepicker']) !!}
        {!! Form::date('end',$end,['class'=>'datepicker']) !!}
        {{Form::select('escenario',$escenarioSelect,$escenario,['id'=>'escenario']) }}
        {{Form::select('modulo',$moduloSelect,$modulo,['id'=>'modulo']) }}
</div>
<div class="col s1">
    {!! Form::button('<i class="fa fa-file-pdf-o fa-2x" ></i>',['class'=>'exportar btn-floating waves-effect waves-light orange darken-1 tooltipped','data-position'=>'top', 'data-delay'=>'50','data-tooltip'=>'Exportar', 'type'=>'submit']) !!}
</div>
{!!form::close()!!}