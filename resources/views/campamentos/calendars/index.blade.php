@extends('layouts.admin.index')

@section('title','Calendario')

@section('head')
    {{--CSS--}}
@endsection

@section('content')
    {{--Contenido--}}
    <div class="row">
        <div class="col l12 m12 s12">
            @include('alert.success')
            <h4>Cursos deportivos</h4>
        </div>
    </div>

    <div class="row">
        <div class="col l12 m12 s12">
            <table id="calendar_table" class="table table-striped table-bordered table-condensed table-hover highlight responsive-table" cellspacing="0" width="100%" style="display: none"   data-order='[[ 0, "asc" ]]'>
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Escenario</th>
                    <th>Disciplina</th>
                    <th>Modulo</th>
                    <th>Días</th>
                    <th>Horario</th>
                    <th>Costo</th>
                    <th>Edad</th>
                    <th>Nivel</th>
                    <th>Cupos</th>
                    <th>Disponibilidad</th>
                    <th>Profesor</th>
                    <th>(Hab/Des)</th>
                    <th>Opciones</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Id</th>
                    <th class="search-filter">Escenario</th>
                    <th class="search-filter">Disciplina</th>
                    <th class="search-filter">Modulo</th>
                    <th>Días</th>
                    <th>Horario</th>
                    <th>Costo</th>
                    <th>Edad</th>
                    <th>Nivel</th>
                    <th>Cupos</th>
                    <th class="search-filter">Disponibilidad</th>
                    <th class="search-filter">Profesor</th>
                    <th>(Hab/Des)</th>
                    <th>Opciones</th>
                </tr>
                </tfoot>
                <tbody>
                @foreach ($calendars as $calendar)
                    <tr>
                        <td>{{ $calendar->id }}</td>
                        <td>{{ $calendar->escenario}}</td>
                        <td>{{ $calendar->disciplina }}</td>
                        <td>{{ $calendar->modulo}}</td>
                        <td>{{ $calendar->dia}}</td>
                        <td>{{ $calendar->start_time.'-'.$calendar->end_time}}</td>
                        <td> $ {{number_format($calendar->mensualidad,2,'.',' ')}}</td>
                        <td>{{ $calendar->init_age.'-'.$calendar->end_age}}</td>
                        <td>{{ $calendar->nivel}}</td>
                        <td>{{ $calendar->cupos}}</td>
                        <td>
                            @if( ($calendar->cupos - $calendar->contador) <=1)
                                <span class="label label-danger">{{ $calendar->cupos - $calendar->contador }}</span>
                            @else
                                <span class="label label-success">{{ $calendar->cupos - $calendar->contador }}</span>
                            @endif
                        </td>
                        <td>
                            {{ $calendar->nombres.' '.$calendar->apellidos}}
                        </td>
                        <td>
                            @if (($calendar->activated)=='1')
                                <span class="label label-success">Activo</span>
                                @if ( Auth::user()->hasRole(['planner','administrator']))
                                    <a href="{{ route('admin.calendars.disable', $calendar->id)}}">
                                        {!! Form::button('<i class="tiny fa fa-check" aria-hidden="true"></i>',['class'=>'label  waves-effect waves-light red darken-1']) !!}
                                    </a>
                                @endif
                            @else
                                <span class="label label-danger">Inactivo</span>
                                @if ( Auth::user()->hasRole(['planner','administrator']))
                                    <a href="{{ route('admin.calendars.enable', $calendar->id)}}">
                                        {!! Form::button('<i class="tiny fa fa-check" aria-hidden="true"></i>',['class'=>'label waves-effect waves-light teal darken-1']) !!}
                                    </a>
                                @endif
                            @endif
                        </td>
                        <td>
                            @if (Auth::user()->hasRole(['planner','administrator']))
                            <a href="{{ route('admin.calendars.edit', $calendar ) }}">
                                {!! Form::button('<i class="tiny fa fa-pencil-square-o" ></i>',['class'=>'label  waves-effect waves-light teal darken-1']) !!}
                            </a>

                            @endif
                                @if( (($calendar->contador)==0 ) && Auth::user()->hasRole(['planner','administrator']))
                                    <a href="{{ route('admin.calendars.delete',$calendar->id) }}" >
                                        {!! Form::button('<i class="tiny fa fa-trash-o" ></i>',['class'=>'label waves-effect waves-light red darken-1']) !!}
                                    </a>
                                @endif

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table><!--end table-responsive-->
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->

@endsection



@section('scripts')

    <script>
        $(document).ready( function () {
            // Agregar inputs de busquedad al datatble
            $('#calendar_table .search-filter').each( function () {
                var title = $(this).text();
                $(this).html( '<input type="text" placeholder="'+title+'" />' );
            } );

            var table =  $('#calendar_table').DataTable({
                lengthMenu: [[10, 25, -1], [10, 25, "Todo"]],
                processing: true,
                stateSave: true,
                "language":{
                    "decimal":        ",",
                    "emptyTable":     "No se encontraron datos en la tabla",
                    "info":           "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    "infoEmpty":      "Mostrando 0 a 0 de 0 registros",
                    "infoFiltered":   "(filtrados de un total _MAX_ registros)",
                    "infoPostFix":    "",
                    "thousands":      " ",
                    "lengthMenu":     "Mostrar _MENU_ registros",
                    "loadingRecords": "Cargando...",
                    "processing":     "Procesando...",
                    "search":         "Buscar:",
                    "zeroRecords":    "No se encrontraron coincidencias",
                    "paginate": {
                        "first":      "Primero",
                        "last":       "Ultimo",
                        "next":       "Siguiente",
                        "previous":   "Anterior"
                    },
                    "aria": {
                        "sortAscending":  ": Activar para ordenar ascendentemente",
                        "sortDescending": ": Activar para ordenar descendentemente"
                    }
                },
                "fnInitComplete":function(){
                    $('#calendar_table').fadeIn();

                }
            });

            // Apply the search
            table.columns().every( function () {
                var that = this;
                $( 'input', this.footer() ).on( 'keyup change', function () {
                    if ( that.search() !== this.value ) {
                        that.search( this.value ).draw();
                    }
                } );
            } );

            $("select").val('10'); //seleccionar valor por defecto del select
            $('select').addClass("browser-default"); //agregar una clase de materializecss de esta forma ya no se pierde el select de numero de registros.
            $('select').material_select(); //inicializar el select de materialize
        });


        function eliminar(btn) {
            var id = btn.value;
            var token = $("#token").val();
            var data = {
                id:id,
            }
            var route=$("#eliminar").attr('href').replace(':CALENDAR',id);





        }






    </script>




@endsection