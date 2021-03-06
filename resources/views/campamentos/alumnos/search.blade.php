    <div id="modal-search" class="modal modal-fixed-footer" >
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
                        <h3 class="panel-title">Personas</h3>
                    </div>
                    <div class="panel-body">

                        <div id="search-result"></div>

                        <div class="preloader-wrapper big" id="loader_page">
                            <div class="spinner-layer spinner-blue">
                                <div class="circle-clipper left">
                                    <div class="circle"></div>
                                </div><div class="gap-patch">
                                    <div class="circle"></div>
                                </div><div class="circle-clipper right">
                                    <div class="circle"></div>
                                </div>
                            </div>
                            <div class="spinner-layer spinner-red">
                                <div class="circle-clipper left">
                                    <div class="circle"></div>
                                </div><div class="gap-patch">
                                    <div class="circle"></div>
                                </div><div class="circle-clipper right">
                                    <div class="circle"></div>
                                </div>
                            </div>
                            <div class="spinner-layer spinner-yellow">
                                <div class="circle-clipper left">
                                    <div class="circle"></div>
                                </div><div class="gap-patch">
                                    <div class="circle"></div>
                                </div><div class="circle-clipper right">
                                    <div class="circle"></div>
                                </div>
                            </div>
                            <div class="spinner-layer spinner-green">
                                <div class="circle-clipper left">
                                    <div class="circle"></div>
                                </div><div class="gap-patch">
                                    <div class="circle"></div>
                                </div><div class="circle-clipper right">
                                    <div class="circle"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer teal">
            {!! Form::button('Cerrar',['class'=>'modal-action modal-close waves-effect waves-ligh btn']) !!}
        </div>
    </div>



