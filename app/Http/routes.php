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

    //adicionar roles a los usuarios
    Route::get('user/{id}/roles', ['as' => 'admin.users.roles','uses'=>'UsersController@roles' ]);
    Route::POST('user/setroles', ['as' => 'admin.users.setroles','uses'=>'UsersController@setRoles' ]);

    //adicionar permisos a los roles
    Route::get('rol/{id}/permisos', ['as' => 'admin.roles.permisos','uses'=>'RolesController@permisos' ]);
    Route::POST('rol/setpermisos', ['as' => 'admin.roles.setpermisos','uses'=>'RolesController@setPermisos' ]);

    //escenario_TRANSPORTE
    Route::get('transporte/{transporte}/escenarios', ['as' => 'admin.get_escenario','uses'=>'TransportesController@get_escenario' ]);
    Route::POST('transporte/escenarios', ['as' => 'admin.set_escenario','uses'=>'TransportesController@set_escenario' ]);

    //perfil de usuario
    Route::get('user/profile',['as' => 'admin.user.profile', 'uses'=>'UsersController@showProfile']);

    Route::resource('users', 'UsersController');
    Route::resource('roles', 'RolesController');
    Route::resource('permissions', 'PermissionsController');
    Route::resource('encuestas', 'EncuestasController');
    Route::resource('personas', 'PersonasController');
    Route::resource('transportes', 'TransportesController');
    Route::resource('escenarios', 'EscenariosController');
    Route::resource('disciplinas', 'DisciplinasController');
    Route::resource('horarios', 'HorariosController');
    Route::resource('dias', 'DiasController');
    Route::resource('modulos', 'ModulosController');

    //enabled modulos
    Route::get('modulos/{modulo}/enable',['as' => 'admin.modulos.enable', 'uses'=>'ModulosController@enable']);
    Route::get('modulos/{modulo}/disable',['as' => 'admin.modulos.disable', 'uses'=>'ModulosController@disable']);
});





