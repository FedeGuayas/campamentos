@extends('layouts.front.master')

    @section('title','Perfil')

    @section('encabezado')
       {{Auth::user()->getNameAttribute()}}
    @endsection

    @section('content')
        <div class="col l12">
            <div class="card-panel">
                <ul class="tabs">
                    <li class="tab col s3 "><a class="active" href="#perfil"><h6><i class="fa fa-user-secret" aria-hidden="true"></i> Perfil</h6></a></li>
                    <li class="tab col s3"><a  href="#representante"><h6><i class="fa fa-registered" aria-hidden="true"></i> Representante</h6></a></li>
                    <li class="tab col s3"><a href="#alumnos" id="getCurso"><h6><i class="fa fa-users" aria-hidden="true"></i> Alumnos</h6></a></li>
                    <li class="tab col s3 "><a href="#inscripciones"><h6><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Inscripciones</h6></a></li>
                </ul>
            </div>
        </div>

        <div class="row">.
            <div class="col  s12">
                @include('alert.request')
                @include('alert.success')
                <div class="card-panel">
                    <div id="perfil" class="animated bounceInUp">

                            @include('online.users.profile.perfil')

                    </div>
                    <div id="representante">
                        <p class="wow fadeIn" data-wow-delay="0.4s">Representante</p><br>
                    </div>
                    <div id="alumnos">
                        <p class="wow fadeIn" data-wow-delay="0.4s">Alumnos</p><br>
                    </div>
                    <div id="inscripciones">
                        <p class="wow fadeIn" data-wow-delay="0.4s">Inscripciones</p><br>
                    </div>
                </div><!--/.card panel-->
            </div><!--/.card col-->
        </div><!--/.row-->



    @endsection

@section('scripts')

@endsection