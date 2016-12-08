{!! Form::open (['route' => 'admin.reports.exportExcel','method' => 'GET'])!!}
<div class="col s12">
    <div class="hidden">
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
        <a href="{{route('admin.reports.exportExcel')}}">
            {!! Form::button('Exportar <i class="fa fa-file-excel-o fa-2x" ></i>',['class'=>'btn exportar btn-xs waves-effect waves-light teal darken-1 tooltipped','data-position'=>'top', 'data-delay'=>'50','data-tooltip'=>'Exportar', 'type'=>'submit']) !!}
        </a>
    </div>
</div>
{!! Form::close() !!}