@extends('layouts.admin.index')

@section('title','Reportes')

@section('content')

    <div class="row">
        <div class="col l12 col m6 col s12">
            <h5>
                Reporte de Matrículas
            </h5>
            @include('alert.success')
        </div>
    </div>

    <div class="row">

        {!! Form::open (['route' => 'admin.reports.matricula','method' => 'GET', 'class'=>'form_datepicker' ])!!}
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

        {!! Form::open (['route' => 'admin.reports.exportMatricula','method' => 'GET'])!!}
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

    </div>
    <hr>
    <div class="row">

    </div>

    <div class="row">
        <div class="col l12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                    <th>Recibo</th>
                    <th>Inscripción</th>
                    <th>Representante</th>
                    <th>CI</th>
                    <th>Usuario</th>
                    <th>Pto Cobro</th>
                    <th>Comprobante</th>
                    <th>Valor</th>
                    </thead>
                    @foreach ($matriculas as $mat )
                        <tr>
                            <td>
                                {{sprintf("%'.05d",$mat->id)}}
                            </td>
                            <td>
                                {{sprintf("%'.05d",$mat->inscripcion_id)}}
                            </td>
                            <td>
                                {{ $mat->factura->representante->persona->getNombreAttribute()}}
                            </td>
                            <td>
                                {{ $mat->factura->representante->persona->num_doc  }}
                            </td>
                            <td>
                                {{ $mat->user->getNameAttribute()}}
                            </td>
                            <td>
                                {{ $mat->escenario->escenario }}
                            </td>
                            <td>
                                {{sprintf("%'.05d",$mat->factura_id)}}
                            </td>
                            <td>
                                $ {{ number_format($mat->matricula,2,' ','.') }}
                            </td>

                        </tr>
                    @endforeach
                </table><!--end table-responsive-->
            </div><!-- end div ./table-responsive-->
            {{ $matriculas->appends(['start'=>$start,'end'=>$end])->links() }}
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->

@endsection

@section('scripts')

    <script>
        $(document).ready(function() {

            //valida el datepicker k no este vacio
            function checkDate() {

                if ($('.datepicker').val() == '') {
                    $('.datepicker').addClass('invalid')
                    $flag=0;
                } else {
                    $('.datepicker').removeClass('invalid')
                    $flag=1;
                }
            }

            $('.datepicker').change(function() {
                checkDate();
            });

            $('.form_datepicker').submit(function() {
                checkDate();
                if ($flag==0){
                    return false;
                }else{
                    return true;
                }
            });


            $('.datepicker').pickadate({
                selectMonths: true, // Creates a dropdown to control month
                selectYears: 5, // Creates a dropdown of 15 years to control year
                format: 'yyyy-mm-dd'
            });

        });

        $(document).ready(function() {
            $("#filtrar").on('click',function(){
                var exportar=$(".exportar");

                exportar.prop("disabled",false);
            });

        });

    </script>

@endsection
