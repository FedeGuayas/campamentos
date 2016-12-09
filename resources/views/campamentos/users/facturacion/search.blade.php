{!! Form::open (['route' => 'admin.facturas.excel','method' => 'GET', 'class'=>'form_datepicker' ])!!}

    <div class="input-field col s2 ">
        {!! Form::label('start','Desde:') !!}
        {!! Form::date('start',$start,['class'=>'datepicker']) !!}
    </div>

    <div class="input-field col s2 ">
        {!! Form::label('end','Hasta:') !!}
        {!! Form::date('end',$end,['class'=>'datepicker']) !!}
    </div>

{{--<div class="clearfix"></div>--}}
<div class="col s3">
{!! Form::button('Filtrar <i class="fa fa-search left"></i>',['class'=>'btn', 'type'=>'submit','id'=>'filtrar']) !!}

</div>

{!!form::close()!!}
