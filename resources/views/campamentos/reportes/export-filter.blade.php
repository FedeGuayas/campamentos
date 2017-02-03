{!! Form::open (['route' => 'admin.reports.exportExcel','method' => 'GET'])!!}
<div class="hidden">
    {!! Form::label('start','Desde:') !!}
    {!! Form::date('start',$start,['class'=>'datepicker']) !!}
    {!! Form::label('end','Hasta:') !!}
    {!! Form::date('end',$end,['class'=>'datepicker']) !!}
</div>
<div class="col s1">
    {!! Form::button('<i class="fa fa-file-excel-o fa-2x" ></i>',['class'=>'exportar btn-floating waves-effect waves-light teal tooltipped','data-position'=>'top', 'data-delay'=>'50','data-tooltip'=>'Exportar', 'type'=>'submit']) !!}
</div>
{!! Form::close() !!}