@extends('layouts.admin.index')

@section('title','Facturas')

@section('content')

    <div class="row">
        <div class="col l8 m8 s">
            @include('alert.success')
            <h4>Comprobantes de Pago</h4>
        </div>
    </div>

    <div class="row">
        <div class="col l12 m12 s12">

            <table id="comprobantes_table" class="table table-striped table-bordered table-condensed table-hover highlight responsive-table" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>No.</th>
                    <th>Valor</th>
                    <th>Descuento</th>
                    <th>Inscripción</th>
                    <th>Alumno</th>
                    <th>Representante</th>
                    <th>Opciones</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th class="search-filter">No.</th>
                    <th>Valor</th>
                    <th>Descuento</th>
                    <th class="search-filter">Inscripción</th>

                    <th class="search-filter">Nomb Alumno</th>
                    <th class="search-filter">Representante</th>
                    <th>Acción</th>
                </tr>
                </tfoot>
                <tbody>

                @foreach ($comprobantes as $comp)
                    <tr>
                        <td>{{ $comp->id }}</td>
                        <td>$ {{number_format($comp->total,2,'.',' ')}}</td>
                        <td>$ {{number_format($comp->descuento,2,'.',' ')}}</td>
                        <td>
                            @foreach($comp->inscripcions as $insc )
                            {{$insc->id}}<br>
                            @endforeach
                        </td>
                        <td>

                                @if ($insc->alumno_id==0)
                                    {{ $insc->factura->representante->persona->getNombreAttribute() }}
                                @else
                                    {{ $insc->alumno->persona->getNombreAttribute() }}
                                @endif
                           

{{--                            @foreach($comp->inscripcions as $insc )--}}
{{--                                {{$insc->alumno->persona->apellidos . ' '. $insc->alumno->persona->nombres}}<br>--}}
                            {{--@endforeach--}}
                        </td>
                        <td>{{$comp->representante->persona->getNombreAttribute()}}</td>
                        <td>
                            {!! Form::button('<i class="fa fa-trash-o" ></i>',['class'=>'modal-trigger btn-floating waves-effect waves-light red darken-1','data-target'=>"modal-delete-$comp->id"]) !!}
                            {{--<a href="{{ route('admin.inscripcions.edit', $comp->id ) }}">--}}
{{--                                {!! Form::button('<i class="fa fa-pencil-square-o" ></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}--}}
                            {{--</a>--}}
                            {{--<a href="{{ route('admin.inscripcions.show', $insc->id ) }}">--}}
{{--                                {!! Form::button('<i class="fa fa-eye"></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}--}}
                            {{--</a>--}}
                        </td>
                    </tr>
                @include('campamentos.facturas.modal-delete')
                @endforeach
                </tbody>
            </table><!--end table-responsive-->
{{--            {{ $representantes->render() }}--}}
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->

@endsection

@section('scripts')
    <script>
        $(document).ready( function () {

            // Agregar inputs de busquedad al datatble
            $('#comprobantes_table .search-filter').each( function () {
                var title = $(this).text();
                $(this).html( '<input type="text" placeholder="'+title+'" />' );
            } );


            var table =  $('#comprobantes_table').DataTable({
                "lengthMenu": [[5, 10, 25], [5, 10, 25]],
                "processing": false,
                "order" : [0,'desc'],
                "language":{
                    "decimal":        "",
                    "emptyTable":     "No se encontraron datos en la tabla",
                    "info":           "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    "infoEmpty":      "Mostrando 0 a 0 de 0 registros",
                    "infoFiltered":   "(filtrados de un total _MAX_ registros)",
                    "infoPostFix":    "",
                    "thousands":      ",",
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
                    $('#comprobantes_table').fadeIn();
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

            $("select").val('5'); //seleccionar valor por defecto del select
            $('select').addClass("browser-default"); //agregar una clase de materializecss de esta forma ya no se pierde el select de numero de registros.
            $('select').material_select(); //inicializar el select de materialize

        });



    </script>
@endsection
