    {{--<div id="modal-delete-{{  $insc->id  }}" class="modal modal-fixed-footer" style="height: 45%">--}}
{{--        {!! Form::open(['route'=>['admin.inscripcions.destroy', $insc->id ],'method'=>'delete']) !!}--}}
        {{--<div class="modal-content">--}}
            {{--<div>--}}
                 {{--<h3>Eliminar Inscripción<i class="fa fa-warning waves-red darken-4 materialize-red-text right medium"></i></h3>--}}
            {{--</div>--}}
            {{--<p >Confirme si desea eliminar la inscripción <strong> {{ $insc->id }}</strong></p>--}}
            {{--<p >! Esta acción no se podra deshacer ¡</p>--}}
        {{--</div>--}}
        {{--<div class="modal-footer">--}}
{{--            {!! Form::button('Aceptar',['class'=>'waves-effect waves-red btn-flat','type'=>'submit']) !!}--}}
{{--            {!! Form::button('Cancelar',['class'=>'modal-action modal-close waves-effect waves-green btn-flat']) !!}--}}
        {{--</div>--}}
{{--        {!! Form::close() !!}--}}
    {{--</div>--}}

    <div id="modal-delete" class="modal fade" style="height: 37%;">
{{--        {!! Form::open(['route'=>['admin.inscripcions.destroy', id ],'method'=>'delete']) !!}--}}
        <div class="modal-header">
            <button class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-2x fa-times right" aria-hidden="true"></i></span></button>
            <h3 class="modal-title">Eliminar inscripcion<i class="fa fa-warning waves-red darken-4 materialize-red-text left medium"></i></h3>
        </div>
        <div class="modal-body">
            <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
            <input type="hidden" id="id">
            <h5>Confirme si desea eliminar la inscripción</h5>
            <h5 >! Esta acción no se podra deshacer ¡</h5>
        </div>
        <div class="modal-footer">
            <a href="#!" class="btn waves-effect waves-light red darken-1" id="btn_eliminar">Eliminar</a>
{{--            {!! link_to('admin.inscripcions.destroy','Eliminar',['id'=>'btn_eliminar', 'class'=>'btn waves-effect waves-light red darken-1'],null) !!}--}}
        </div>
{{--                {!! Form::close() !!}--}}
    </div>



