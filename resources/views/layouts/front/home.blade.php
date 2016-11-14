@extends('layouts.front.master-plane')

@section('content')
<!--Mask-->
<div class="view hm-black-strong">
    <div class="full-bg-img flex-center">
        <div class="container">
            <div class="row" id="home">
                @yield('content')
            </div>
        </div>
    </div>
</div>
        <!--/.Mask-->

@endsection






