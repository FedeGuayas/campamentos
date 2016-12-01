@extends('layouts.admin.index')

@section('title', 'Representante')

@section('content')

    <div class="row">
        <div class="col l6 offset-l1 m6 s12">

            <div class="card sticky-action hoverable large">

                    <div class="card-image waves-effect waves-block waves-light">
                        @if (empty($representante->foto))
                            <img class="responsive-img activator" alt="Imagen del usuario"
                                 src="..." style="max-width: 70%">
                        @else
                            <img class="responsive-img activator"
                                 src="{{ asset('dist/img/representantes/perfil/'.$representante->foto)}}" style='max-width: 70%'>
                        @endif
                    </div>


                <div class="card-content">
                    <span class="card-title activator grey-text text-darken-4">{{$representante->persona->getNombreAttribute()}}<i class="fa fa-ellipsis-v right" aria-hidden="true"></i></span>

                    <p class="blue-text text-darken-2">Clik sobre la Imagen para mostrar mas informacion</p>
                </div>

                <div class="card-action">
                    <a href="{{ route('admin.representantes.index') }}" class="tooltipped" data-position="top" data-delay="50" data-tooltip="Regresar">
                        {!! Form::button('<i class="fa fa-hand-o-left" aria-hidden="true"></i>',['class'=>'btn waves-effect waves-light darken-1']) !!}
                    </a>
                </div>

                <div class="card-reveal">
                    <span class="card-title grey-text text-darken-4">{{$representante->persona->getNombreAttribute()}}<i class="fa fa-times right" aria-hidden="true"></i></span>

                    <div class="row">
                        <div class="col s12">
                            <ul class="tabs">
                                <li class="tab col s3"><a class="active" href="#dir">Dirección</a></li>
                                <li class="tab col s3"><a href="#tel">Teléfono</a></li>
                                <li class="tab col s3"><a href="#email">Email</a></li>
                                <li class="tab col s3"><a href="#foto_ced">CI</a></li>
                            </ul>
                        </div>
                        <div id="dir" class="col s12">
                            <p class="flow-text">
                                <i class="fa fa-map-marker large teal-text text-darken-2" aria-hidden="true"></i>
                                <h5>{{$representante->persona->direccion}}</h5>
                            </p>
                        </div>
                        <div id="tel" class="col s12">
                            <p class="flow-text">
                                <i class="fa fa-mobile large teal-text text-darken-2" aria-hidden="true"></i><br>
                                Tel1: {{$representante->phone}}<br>
                                Tel2: {{$representante->persona->telefono}}
                            </p>
                        </div>
                        <div id="email" class="col s12">
                            <p class="flow-text">
                                <i class="fa fa-envelope-o large teal-text text-darken-2 " aria-hidden="true"></i><br>
                                {{$representante->persona->email}}
                            </p>
                        </div>
                        <div id="foto_ced" class="col s12">
                            <img class="responsive-img" src="{{ asset('dist/img/representantes/cedula/'.$representante->foto_ced)}}" style="max-width: 70%">
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

@endsection

@section('scripts')
    <script>
    $(document).ready(function(){
    $('ul.tabs').tabs();
    });
    </script>
    @endsection