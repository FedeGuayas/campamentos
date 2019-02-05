    <div id="search-repre" class="modal modal-fixed-footer" >
        <div class="modal-content">
            <div class="row">
                <div class="col s12 ">
                    <h5 class=" flow-text" > Buscar Representante</h5>
                    {!! Form::open(['class'=>'form_noEnter']) !!}
                        <div class="col s4">
                            <div class="input-field ">
                                {{--<i class="fa fa-search medium prefix"></i>--}}
                                {!! Form::text('search',null,['id'=>'search', 'placeholder'=>'Nombres o CI del Representante...','class'=>'tooltipped','data-position'=>'top', 'data-delay'=>'50', 'data-tooltip'=>'Ingrese cédula o nombres a buscar']) !!}
                            </div>
                        </div>
                        <div class="col s6">
                            <div class="input-field ">
                                <a href="#" type="button" id="Buscar" class="btn-floating indigo waves-effect waves-light tooltipped"
                                   data-position="top" data-delay="50" data-tooltip="Buscar"><i class="fa fa-search"></i>
                                </a>
                                {{--{!! link_to('#','Buscar "fa fa-search medium prefix"></i>',['class'=>'btn btn-floating waves-effect waves-light', 'id'=>'Buscar']) !!}--}}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="card">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Resultado</h3>
                    </div>

                    <div class="panel-body center-align">

                        <div id="search-result"></div>

                        <div class="preloader-wrapper" id="loader_page">
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
        <div class="modal-footer">
            <div class="left">
                <span class="left-align text-muted red-text"> Para seleccionar un representante, agregar y cerrar esta ventana</span>
            </div>
            <div class="right">
                {!! Form::button('Cerrar',['class'=>'modal-action modal-close waves-effect waves-light btn']) !!}
            </div>

        </div>
    </div>



