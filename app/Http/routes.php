<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();



Route::get('/home', 'HomeController@index');
//Para manejar la respuesta cuando el usuario de en el link de activar la cuenta
Route::get('user/activation/{token}', 'Auth\AuthController@activateUser')->name('user.activate');

/*Front end for register online */
//Route::get('front', function () {
//    return view('layouts/front');
//});


/*OK*/
/*Route group admin, and login is forces by middeware auth*/
Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
//Route::group(['prefix' => 'admin'], function () {

    //borrar
    Route::get('index', ['as' => 'admin.index', function () {
        return view('layouts.admin.index');
    }]);

    //Buscar represenante
    Route::POST('representantes/search',['as' => 'admin.representantes.beforeSearch', 'uses'=>'RepresentantesController@beforeSearch']);
    Route::get('representantes/search/{search}',['as' => 'admin.representantes.search', 'uses'=>'RepresentantesController@search']);
    Route::get('representantes/listSearch/{d?}',['as' => 'admin.representantes.listSearch', 'uses'=>'RepresentantesController@listSearch']);



    //adicionar roles a los usuarios
    Route::get('user/{id}/roles', ['as' => 'admin.users.roles','uses'=>'UsersController@roles' ]);
    Route::POST('user/setroles', ['as' => 'admin.users.setroles','uses'=>'UsersController@setRoles' ]);

    //adicionar permisos a los roles
    Route::get('rol/{id}/permisos', ['as' => 'admin.roles.permisos','uses'=>'RolesController@permisos' ]);
    Route::POST('rol/setpermisos', ['as' => 'admin.roles.setpermisos','uses'=>'RolesController@setPermisos' ]);

    //escenario_TRANSPORTE Many to Many
    Route::get('transporte/{transporte}/escenarios', ['as' => 'admin.get_escenario','uses'=>'TransportesController@get_escenario' ]);
    Route::POST('transporte/escenarios', ['as' => 'admin.set_escenario','uses'=>'TransportesController@set_escenario' ]);
    Route::DELETE('transporte/{transporte}/escenarios/{escenario}', ['as' => 'admin.transportes.destroyEscenario','uses'=>'TransportesController@destroyEscenario' ]);

    //perfil de usuario
    Route::get('user/profile',['as' => 'admin.user.profile', 'uses'=>'UsersController@showProfile']);

    Route::resource('users', 'UsersController');
    Route::resource('roles', 'RolesController');
    Route::resource('permissions', 'PermissionsController');
    Route::resource('encuestas', 'EncuestasController');
    Route::resource('representantes', 'RepresentantesController');
    Route::resource('alumnos', 'AlumnosController');
    Route::resource('transportes', 'TransportesController');
    Route::resource('escenarios', 'EscenariosController');
    Route::resource('disciplinas', 'DisciplinasController');
    Route::resource('horarios', 'HorariosController');
    Route::resource('dias', 'DiasController');
    Route::resource('modulos', 'ModulosController');
    Route::resource('programs', 'ProgramsController');

    //enabled, disabled modulos
    Route::get('modulos/{modulo}/enable',['as' => 'admin.modulos.enable', 'uses'=>'ModulosController@enable']);
    Route::get('modulos/{modulo}/disable',['as' => 'admin.modulos.disable', 'uses'=>'ModulosController@disable']);

    //enabled, disabled dias
    Route::get('dias/{dia}/enable',['as' => 'admin.dias.enable', 'uses'=>'DiasController@enable']);
    Route::get('dias/{dia}/disable',['as' => 'admin.dias.disable', 'uses'=>'DiasController@disable']);

    //enabled, disabled horarios
    Route::get('horarios/{horario}/enable',['as' => 'admin.horarios.enable', 'uses'=>'HorariosController@enable']);
    Route::get('horarios/{horario}/disable',['as' => 'admin.horarios.disable', 'uses'=>'HorariosController@disable']);

    //enabled, disabled escenarios
    Route::get('escenarios/{escenario}/enable',['as' => 'admin.escenarios.enable', 'uses'=>'EscenariosController@enable']);
    Route::get('escenarios/{escenario}/disable',['as' => 'admin.escenarios.disable', 'uses'=>'EscenariosController@disable']);

    //enabled, disabled disciplinas
    Route::get('disciplinas/{disciplina}/enable',['as' => 'admin.disciplinas.enable', 'uses'=>'DisciplinasController@enable']);
    Route::get('disciplinas/{disciplina}/disable',['as' => 'admin.disciplinas.disable', 'uses'=>'DisciplinasController@disable']);

    //enabled, disabled programs
    Route::get('programs/{program}/enable',['as' => 'admin.programs.enable', 'uses'=>'ProgramsController@enable']);
    Route::get('programs/{program}/disable',['as' => 'admin.programs.disable', 'uses'=>'ProgramsController@disable']);
    

    
});





