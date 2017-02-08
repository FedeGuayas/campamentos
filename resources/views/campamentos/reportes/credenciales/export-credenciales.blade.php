{!! Form::open (['route' => 'admin.reports.export-credenciales','method' => 'GET', 'target'=>'_blank'])!!}
<div class="hidden">
    {!! Form::text('start',$start,['class'=>'validate',  'id'=>'start']) !!}
    {!! Form::text('end',$end,['class'=>'validate', 'id'=>'end']) !!}
</div>
<div class="col s1">
    {!! Form::button('<i class="fa fa-file-pdf-o fa-2x" ></i>',['class'=>'exportar btn-floating waves-effect waves-light orange darken-1 tooltipped','data-position'=>'top', 'data-delay'=>'50','data-tooltip'=>'Exportar', 'type'=>'submit']) !!}
</div>
{!!form::close()!!}