    <div id="modal-delete-{{ $rol->id }}" class="modal modal-fixed-footer" style="height: 45%">
        {!! Form::open(['route'=>['admin.roles.destroy',$rol->id],'method'=>'delete']) !!}
        <div class="modal-content">
            <div>
                 <h3>Eliminar Rol<i class="fa fa-warning waves-red darken-4 materialize-red-text right medium"></i></h3>
            </div>
            <p >Confirme si desea eliminar el Rol <strong>{{$rol->display_name}}</strong></p>
            <p >! Esta acción no se podra deshacer ¡</p>
        </div>
        <div class="modal-footer">
            {!! Form::button('Aceptar',['class'=>'waves-effect waves-red btn-flat','type'=>'submit']) !!}
            {!! Form::button('Cancelar',['class'=>'modal-action modal-close waves-effect waves-green btn-flat']) !!}
        </div>
        {!! Form::close() !!}
    </div>

