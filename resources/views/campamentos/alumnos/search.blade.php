    <div id="modal-search" class="modal modal-fixed-footer" >
        {{--{!! Form::open(['class'=>'form_noEnter']) !!}--}}
        <div class="modal-content">
            <div class="row">
                <div class="col s12">
                    <p class=" flow-text" > Buscar Representante</p>
                    {!! Form::open(['class'=>'form_noEnter']) !!}
                        <div class="col s4">
                            <div class="input-field ">
                                <i class="fa fa-search medium prefix"></i>
                                {!! Form::text('search',null,['id'=>'search', 'placeholder'=>'Nombres o CI del Representante...']) !!}
                            </div>
                        </div>
                        <div class="col s6">
                            <div class="input-field ">
                                {!! link_to('#','Buscar',['class'=>'btn waves-effect waves-light', 'id'=>'Buscar']) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>

            <div class="card-panel teal">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">Representantes</h3>
                    </div>
                    <div class="panel-body">

                        <div id="search-result"></div>

                    </div>
                </div>
            </div>

        </div>
        <div class="modal-footer teal">
            {!! link_to('#','Aceptar',['class'=>'btn waves-effect waves-light', 'id'=>'ADD_REP']) !!}
            {!! Form::button('Cancelar',['class'=>'modal-action modal-close waves-effect waves-ligh btn']) !!}
        </div>
        {{--{!! Form::close() !!}--}}
    </div>



