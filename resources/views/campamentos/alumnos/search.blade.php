    <div id="modal-search" class="modal modal-fixed-footer" >
{{--        {!! Form::open(['route'=>['admin.representantes.index']]) !!}--}}
        <div class="modal-content">
            <div class="row">
                <div class="col s12">
                    <p class=" flow-text" > Buscar Representante</p>
                    {!! Form::open(['id'=>'form_searchRepresentante']) !!}
                        <div class="col s6">
                            <div class="input-field ">
                                {!! Form::text('search',null,['id'=>'search']) !!}
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
            {!! Form::button('Aceptar',['class'=>'waves-effect waves-ligh btn','type'=>'submit']) !!}
            {!! Form::button('Cancelar',['class'=>'modal-action modal-close waves-effect waves-ligh btn']) !!}
        </div>
        {{--{!! Form::close() !!}--}}
    </div>



