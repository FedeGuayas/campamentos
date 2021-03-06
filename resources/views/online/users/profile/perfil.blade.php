<h5 class="header teal-text text-darken-2">Información de usuario</h5>
<div class="row">
    {{--tarjeta de usuario--}}
    <div class="col s12 m6 l4">
        <div class="card hoverable medium">

            <div class="waves-effect waves-block waves-light" style="text-align: center; padding-top: 15px;">
                @if (empty($user->avatar))
                    {{--<img class="activator circle" alt="Avatar del usuario"--}}
                    <img class="circle" alt="Avatar del usuario"
                         src="{{ asset('/img/camp/user-avatar-default.png')}}" style="max-width: 200px;">
                @else
                    {{--<img class="responsive-img activator circle"--}}
                    <img class="responsive-img circle"
                         src="{{ asset('/dist/img/users/avatar/'.$user->avatar)}}"
                         onerror="this.src='{{ asset('/img/camp/user-avatar-default.png')}}';"
                         style="max-width: 200px;  ">
                @endif
            </div>

            <div class="card-content">
                <span class="card-title grey-text text-darken-4">{{$user->getNameAttribute()}}
                    {{--<i class="fa fa-ellipsis-v right" aria-hidden="true"></i>--}}
                </span>
                <p class="blue-text text-darken-2"></p>
            </div>

            {{--<div class="card-reveal">--}}
                {{--<span class="card-title grey-text text-darken-4">{{$user->getNameAttribute()}}<i--}}
                            {{--class="fa fa-times right " aria-hidden="true"></i></span>--}}
                {{--<div class="row">--}}
                    {{--<div class="col s12">--}}
                        {{--<ul class="tabs">--}}
                            {{--<li class="tab col s3"><a class="active" href="#nombre">Nombre</a></li>--}}
                            {{--<li class="tab col s3"><a href="#email">Email</a></li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                    {{--<div id="email" class="col s12">--}}
                        {{--<p class="flow-text">--}}
                            {{--<i class="fa fa-envelope-o large teal-text text-darken-2 " aria-hidden="true"></i><br>--}}
                            {{--Correo--}}{{--{{$representante->persona->email}}--}}
                        {{--</p>--}}
                    {{--</div>--}}
                    {{--<div id="nombre" class="col s12">--}}
                        {{--<img class="responsive-img" src="{{ asset('dist/img/representantes/cedula/'.$representante->foto_ced)}}" style="max-width: 70%">--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}

        </div>
    </div> {{--tarjeta de usuario--}}

    {{--Editar acceso de usuario --}}
    <div class="col s12 m6 l8">
        <div class="card sticky-action hoverable medium">

            <div class="card-content">
                <span class="card-title">Editar sus datos</span>
                <span class="card-title activator grey-text text-darken-4">
                    {!! Form::button('<i class="fa fa-pencil" aria-hidden="true"></i>',['class'=>'btn-floating right waves-effect waves-light darken-1 tooltipped','data-position'=>'top', 'data-delay'=>'50', 'data-tooltip'=>'Editar']) !!}
                </span>

                <table>
                    <thead>
                    <tr>
                        <th data-field="user">Usuario</th>
                        <th data-field="mail">Email</th>
                        <th data-field="avatar">Avatar</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{$user->getNameAttribute()}}</td>
                        <td>{{$user->email}}</td>
                        <td>
                            @if (empty($user->avatar))
                                <img class=" activator circle" alt="Avatar del usuario"
                                     src="{{ asset('/img/camp/user-avatar-default.png')}}" style="max-width: 200px;">
                            @else
                                <img class="responsive-img circle"
                                     src="{{ asset('/dist/img/users/avatar/'.$user->avatar)}}"
                                     onerror="this.src='{{ asset('/img/camp/user-avatar-default.png')}}';"
                                     style="max-width: 100px">
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            {{--Editar perfil de usuario online--}}
            <div class="card-reveal">
                <span class="card-title grey-text text-darken-4">Editar: {{$user->getNameAttribute()}}<i
                            data-position="top" data-delay="50" data-tooltip="Cerrar"
                            class="fa fa-times right tooltipped" aria-hidden="true"></i></span>
                {{--                {!! Form::model($user,['route'=>['user.update',$user->id], 'method'=>'PUT', 'files'=>'true'])  !!}--}}
                {!! Form::model($user,['id'=>'form_edit_user', 'files'=>'true'])  !!}

                <div class="row">
                    <div class="input-field col l6 m6 s12 ">
                        <i class="fa fa-user prefix"></i>
                        {!! Form::label('first_name','Nombres:*') !!}
                        {!! Form::text('first_name',null,['class'=>'validate','style'=>'text-transform:uppercase']) !!}
                    </div>

                    <div class="input-field col l6 m6 s12">
                        {!! Form::label('last_name','Apellidos:*') !!}
                        {!! Form::text('last_name',null,['class'=>'validate','style'=>'text-transform:uppercase']) !!}
                    </div>
                </div>

                <div class="row">
                    {{--<div class="input-field col l6 m6 s12">--}}
                        {{--<i class="fa fa-envelope prefix"></i>--}}
                        {{--{!! Form::label('email','Correo:') !!}--}}
                        {{--{!! Form::email('email',null,['class'=>'validate', 'disabled']) !!}--}}
                    {{--</div>--}}

                    <div class="col l6 m6 s12">
                        <a href="{{ route('user.password.edit') }}" class="tooltipped" data-position="top"
                           data-delay="50" data-tooltip="Cambiar contraseña">
                            {!! Form::button('<i class="fa fa-lock prefix" aria-hidden="true"></i>',['class'=>'btn-floating  waves-effect  waves-light red darken-1']) !!}
                            Cambiar la contraseña
                        </a>
                    </div>
                </div>

                <div class="row">

                    <div class="col s6">
                        <i class="fa  fa-2x fa-image prefix"></i>
                        {!! Form::label('Avatar') !!}
                        {!! Form::file('avatar') !!}
                    </div>
                    <div class="col l6 m6 s12 right-aligned">
                        {!! Form::button('<i class="fa fa-save"></i>',['class'=>'btn waves-effect waves-light tooltipped','id'=>'edit_user','data-position'=>'top', 'data-delay'=>'50', 'data-tooltip'=>'Guardar']) !!}
                        {!! Form::button('<i class="fa fa-close"></i>',['class'=>'btn waves-effect waves-light red darken-1 tooltipped','type' => 'reset', 'data-position'=>'top', 'data-delay'=>'50', 'data-tooltip'=>'Cancelar']) !!}
                    </div>
                </div>

                {!! Form::close() !!}
            </div>{{--./card-reveal--}}

        </div>{{--./card sticky-action hoverable medium --}}

    </div>{{--Fin Editar usuario --}}

</div>



