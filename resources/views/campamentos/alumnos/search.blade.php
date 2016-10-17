    <div id="modal-search" class="modal modal-fixed-footer" >
{{--        {!! Form::open(['route'=>['admin.representantes.index']]) !!}--}}
        <div class="modal-content">
            <div>
                 <p class=" flow-text" > Buscar Representante</p>


    <nav>
        <div class="nav-wrapper teal">
             {!! Form::open(['route'=>['admin.representantes.search','search'=>'search'], 'method'=>'GET', 'role'=>'search']) !!}
                <div class="input-field">
                    <input id="search" type="search" required name="search">
                    <label for="search"><i class="material-icons"><i class="fa fa-search"></i></i></label>
                    <i class="material-icons"><i class="fa fa-close"></i></i>
                </div>
            {!! Form::close() !!}
        </div>
    </nav>




                {{--<div class="search">--}}


                            {{--<div class="input-field">--}}
{{--                               {!! Form::text('search',null,['id'=>'search','search']) !!}--}}
{{--                                {!! Form::label('search<i class="fa fa-search"></i>') !!}--}}
                                {{--<input id="search" type="search" >--}}
                                {{--<label for="search"><i class="fa fa-search small"></i><i class="fa fa-close prefix right"></i></label>--}}

                            {{--</div>--}}
                            {{--{!! Form::close() !!}--}}
                    {{--</div>--}}

            </div>



            <table class="table table-striped table-bordered table-condensed table-hover highlight responsive-table">
                <thead>
                <th>Id</th>
                <th>Nombres y Apellidos</th>
                <th>Identificación</th>
                <th>Adicionar</th>
                </thead>
{{--                @foreach ($representante as $rep)--}}
                    <tr>
                        {{--<td>{{ $rep->id }}</td>--}}
                        {{--<td>{{ $rep->persona->getNombreAttribute() }}</td>--}}
                        {{--<td>{{ $rep->persona->num_doc }}</td>--}}
                        {{--<td>{{ $rep->persona->tipo_doc }}</td>--}}
                        {{--<td>{{ $rep->persona->genero }}</td>--}}
                        {{--<td>--}}
                            {{--{!! Form::button('<i class="fa fa-trash-o" ></i>',['class'=>'modal-trigger btn-floating waves-effect waves-light red darken-1','data-target'=>"modal-delete-$rep->id"]) !!}--}}
                            {{--<a href="{{ route('admin.representantes.edit', $rep->id ) }}">--}}
                                {{--{!! Form::button('<i class="fa fa-pencil-square-o" ></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}--}}
                            {{--</a>--}}
                            {{--<a href="{{ route('admin.representantes.show', $rep->id ) }}">--}}
                                {{--{!! Form::button('<i class="fa fa-eye"></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}--}}
                            {{--</a>--}}
                            {{--<a href="{{ route('admin.alumnos.create' ) }}">--}}
                                {{--{!! Form::button('<i class="fa fa-child" aria-hidden="true"></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}--}}
                            {{--</a>--}}

                        </td>
                    </tr>

                {{--@endforeach--}}
            </table><!--end table-responsive-->


        </div>
        <div class="modal-footer teal">
            {!! Form::button('Aceptar',['class'=>'waves-effect waves-ligh btn','type'=>'submit']) !!}
            {!! Form::button('Cancelar',['class'=>'modal-action modal-close waves-effect waves-ligh btn']) !!}
        </div>
        {{--{!! Form::close() !!}--}}
    </div>

