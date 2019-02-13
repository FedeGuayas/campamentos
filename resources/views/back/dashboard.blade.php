@extends('layouts.admin.index')


@section('content')

    <h1 class="flow-text">Dashboard</h1>
    <div class="row">

        <div class="col s12 m8 offset-m2 l6 offset-l3">
            <div class="section" id="chart1">
                {!! $ventas_chartjs->render() !!}
            </div>
        </div>

    </div>



@endsection

@section('scripts')
    {!! Html::script('plugins/chartjs/chartjs.bundle.min.js') !!}

@endsection
