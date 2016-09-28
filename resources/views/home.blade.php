@extends('layouts.front.home')

@section('content')
{{--<div class="container">--}}
    {{--<div class="row">--}}
<div class="description">

    <h2 class="h2-responsive wow fadeInLeft">Dashboart: {{Auth::user()->getNameAttribute()}} </h2>
    <hr class="hr-dark">
    <p class="wow fadeInLeft" data-wow-delay="0.4s">Inscribirme</p><br>
    <p class="wow fadeInLeft" data-wow-delay="0.4s">Perfil!</p><br>
    <p class="wow fadeInLeft" data-wow-delay="0.4s">Representante!</p><br>
    <p class="wow fadeInLeft" data-wow-delay="0.4s">Alumnos!</p><br>
    <p class="wow fadeInLeft" data-wow-delay="0.4s">Disciplinas!</p><br>
    <p class="wow fadeInLeft" data-wow-delay="0.4s">Escenarios!</p><br>



</div>



@endsection
