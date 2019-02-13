@extends('layouts.front.master-plane')

@section('title','Resultado')


@section('body')
    <nav>
        <div class="nav-wrapper teal darken-1">
            {!! Form::open(['route'=>'curso-search', 'method'=>'GET']) !!}
            <div class="input-field">
                <input id="termino" type="search" name="termino" required placeholder="Buscar cursos"
                       autocomplete="off">
                <label class="label-icon" for="search"><i class="material-icons">search</i></label>
                <i class="material-icons">close</i>
            </div>
            {!! Form::close() !!}
            <a href="{{url('/')}}" class="btn-floating btn-large waves-effect waves-light red right tooltipped"
               data-position="left" data-tooltip="Inicio"><i class="fa fa-1x fa-home"></i></a>
        </div>
    </nav>

    <div class="container">

        <div class="row center">
            <h5 class="header teal-text"> Resultados para : {{$termino}}</h5>
        </div>

        <div class="row">
            @if ($cursos->total() == 0 )
                <div class="col s12 ">
                    <div class="card-panel red accent-1">
                        <span class="white-text">
                            Lo sentimos no se encontraron resultados para su busqueda. Intentelo de nuevo con un nuevo término.
                        </span>
                    </div>
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col s12 wow fadeIn ">

                @foreach($cursos as $curso)
                    @if(($curso->cupos - $curso->contador) >=1)

                        <div class="col s12 m4">
                            <div class="card big hoverable z-depth-4 sticky-action  wow fadeIn"
                                 data-wow-delay="0.3s">
                                <div class="card-image waves-effect waves-block waves-light">
                                    @if($curso->program->imagen)
                                        <img class="activator tooltipped" data-position="bottom"
                                             data-tooltip="Click + Info"
                                             src="{{ asset('/img/camp/disciplinas/'.$curso->program->imagen)}}"
                                             style="max-height: 300px;">
                                    @else
                                        <img class="activator tooltipped" data-position="bottom"
                                             data-tooltip="Click + Info" src="{{ asset('/img/camp/fdg-logo.png')}}">
                                    @endif
                                </div>
                                <div class="card-content">
                                    <span class="card-title activator grey-text text-darken-4">
                                        Curso
                                        <i class="material-icons right">more_vert</i>
                                    </span>
                                    <p>
                                        {{$curso->program->disciplina->disciplina}}
                                        / {{$curso->program->escenario->escenario}}
                                    </p>
                                    <p style="font-size: 11px;">
                                        {{$curso->dia->dia}}
                                        / {{$curso->horario->start_time.' - '.$curso->horario->end_time}}
                                        / {{ $curso->init_age.'-'.$curso->end_age}} años.
                                        <br>
                                        <span class="purple-text"> Inicio {{$curso->program->modulo->inicio}} </span>
                                    </p>
                                </div>
                                <div class="card-action">
                                    <div class="clearfix">
                                        <div class="pull-left price teal-text">
                                            $ {{number_format($curso->mensualidad,2,'.',' ')}}</div>
                                    </div>
                                </div>
                                <div class="card-reveal">
                                    <span class="card-title grey-text text-darken-4">
                                        {{$curso->program->disciplina->disciplina}}

                                        <i class="material-icons right">close</i></span>
                                    <table class="table highlight" cellspacing="0" width="100%"
                                           style="width: 100%">
                                        <tr>
                                            <th>Escenario</th>
                                            <td>
                                                {{$curso->program->escenario->escenario}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Mes</th>
                                            <td>
                                                {{$curso->program->modulo->modulo}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Matrícula</th>
                                            <td>
                                                $ {{number_format($curso->program->matricula,2,'.',' ')}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Disponibilidad</th>
                                            <td>
                                                @if( ($curso->cupos - $curso->contador) <=1)
                                                    <span class="label label-danger">{{ $curso->cupos - $curso->contador }}</span>
                                                @else
                                                    <span class="label label-success">{{ $curso->cupos - $curso->contador }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Dias</th>
                                            <td>
                                                {{$curso->dia->dia}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Horarios</th>
                                            <td>
                                                {{$curso->horario->start_time.' - '.$curso->horario->end_time}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Edades</th>
                                            <td>
                                                {{ $curso->init_age.'-'.$curso->end_age}} años
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                    @endif
                @endforeach


            </div>
        </div><!--/.row-->
        <div class="row center">

            {{ $cursos->appends(['termino'=>$termino])->links() }}

            <h5 class="header  teal-text darken-4">
                Total de resultados: {{$cursos->total()}}
            </h5>
        </div>
        <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
    </div>



@endsection

@section('scripts')
    <script>
        var cursos = {!! json_encode($cursos->toArray(), JSON_HEX_TAG) !!};
        $(document).ready(function () {
           // console.log(cursos);

        });

    </script>
@endsection