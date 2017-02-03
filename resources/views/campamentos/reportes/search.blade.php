{!! Form::open (['route' => 'admin.reports.excel','method' => 'GET', 'class'=>'form_datepicker' ])!!}
    <div class="input-field col s2 ">
        {!! Form::label('start','Desde:') !!}
        {!! Form::date('start',$start,['class'=>'datepicker']) !!}
    </div>
    <div class="input-field col s2 ">
        {!! Form::label('end','Hasta:') !!}
        {!! Form::date('end',$end,['class'=>'datepicker']) !!}
    </div>
<div class="col s1 offset-s8">
{!! Form::button('<i class="fa fa-search left"></i>',['class'=>'btn-floating waves-effect waves-light blue darken-2 tooltipped','data-position'=>'top', 'data-delay'=>'50','data-tooltip'=>'Filtrar', 'type'=>'submit','id'=>'filtrar']) !!}
</div>
{!!form::close()!!}
