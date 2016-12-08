{!! Form::open (['route' => 'admin.reports.excel','method' => 'GET', 'class'=>'form_datepicker' ])!!}
<p>Periodo de Inscripcion:</p>
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
{{--<div class="col-sm-3">--}}

{{--</div><!-- /.col-lg-3 -->--}}

{{--<div class="col-sm-3">--}}
    {{--<div class="form-group">--}}
        {{--{!! Form::label('buscar','Buscar') !!}--}}
        {{--<div class="input-group">--}}
            {{--{!! Form::select('trabajador',$trabajadores,$trabajador,['placeholder'=>'Seleccione trabajador','class'=>'form-control','id'=>'trabajador']) !!}--}}
                    {{--<span class="input-group-btn">--}}
                        {{--<a href=""  class="btn btn-primary" title="Buscar"><i class="fa fa-search" aria-hidden="true"></i>--}}
                            {{--{!! Form::submit('Buscar',['class'=>'btn btn-primary']) !!}--}}
                        {{--</a>--}}
                    {{--</span>--}}
        {{--</div><!-- /input-group -->--}}
    {{--</div>--}}
{{--</div><!-- /.col-lg-3 -->--}}
{!!form::close()!!}
