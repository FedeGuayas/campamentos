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

    //*****SELECT DINAMICOS para inscripcion****//

    //obtener los escenarios para un modulo  para select dinamico
    Route::get('inscripcions/escenarios/{modulo_id}','ProgramsController@getEscenarios');
    //obtener las disciplina para un escenario  para select dinamico
    Route::get('inscripcions/disciplinas/{escenario_id}','ProgramsController@getDisciplinas');
    //obtener los dias para un programa, data defien al programa(esc,disc,modulo)
    Route::get('inscripcions/dias{data?}',['uses'=>'CalendarsController@getDias','as'=>'program.getDias']);
    //obtener los horarios para el dia
    Route::get('inscripcions/horario/{data?}','CalendarsController@getHorario');
    //obtener los niveles para el dia y horario
    Route::get('inscripcions/nivel/{data?}','CalendarsController@getNivel');
    //obtener ontener el id del calendario o curso
    Route::get('inscripcions/curso/{data?}','CalendarsController@getCurso');
    //obtener los alumnos de un trabajador
    Route::get('inscripcions/alumnos/{representante_id}','RepresentantesController@getAlumnos');

    //*****Actualizar costo de inscripcion****//
    Route::get('inscripcions/costo/{data?}','InscripcionsController@costoUpdate');
    
    //******** Importar personas de archivo excel********//
    Route::get('/persons/import', ['as'=>'persons.import','uses'=>'ImportController@getPersonas']);
    Route::get('/persons/truncate', ['as'=>'persons.truncate','uses'=>'ImportController@truncate']);
    Route::post('/persons/import', ['as'=>'persons.store','uses'=>'ImportController@postPersonsImport']);
    
    //Buscar represenante
    Route::POST('representantes/search',['as' => 'admin.representantes.beforeSearch', 'uses'=>'RepresentantesController@beforeSearch']);
    Route::get('representantes/search/{search}',['as' => 'admin.representantes.search', 'uses'=>'RepresentantesController@search']);
    Route::get('representantes/listSearch/{d?}',['as' => 'admin.representantes.listSearch', 'uses'=>'RepresentantesController@listSearch']);

    //crear represntante a partir de la lista de persona importada
    Route::get('/persona/{id}/representante', ['as'=>'persona.representante','uses'=>'PersonasController@postRepresentante']);

    //crear alumno a partir de dar clik en el representante
    Route::get(' alumnos/create{representante?}',['as' => 'admin.alumnos.create', 'uses'=>'AlumnosController@create']);

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
    
    //mostrar reservas
    Route::get('/inscripcions/reservas',['as' => 'admin.inscripcions.reservas', 'uses'=>'InscripcionsController@reservas']);
    //cancelar reserva
    Route::get('/inscripcions/reserva/{id}/cancel',['as' => 'admin.reserva.cancel', 'uses'=>'InscripcionsController@reservaCancel']);
    //confirmar reserva
    Route::get('/inscripcions/reserva/{id}/confirm',['as' => 'admin.reserva.confirm', 'uses'=>'InscripcionsController@reservaConfirm']);

    Route::resource('users', 'UsersController');
    Route::resource('roles', 'RolesController');
    Route::resource('permissions', 'PermissionsController');
    Route::resource('encuestas', 'EncuestasController');
    Route::resource('representantes', 'RepresentantesController');
    Route::resource('personas', 'PersonasController');
    Route::resource('alumnos', 'AlumnosController');
    Route::resource('transportes', 'TransportesController');
    Route::resource('escenarios', 'EscenariosController');
    Route::resource('disciplinas', 'DisciplinasController');
    Route::resource('horarios', 'HorariosController');
    Route::resource('dias', 'DiasController');
    Route::resource('modulos', 'ModulosController');
    Route::resource('programs', 'ProgramsController');
    Route::resource('fpagos', 'PagosController');
    Route::resource('calendars', 'CalendarsController');
    Route::resource('descuentos', 'DescuentosController');
    Route::resource('facturas', 'FacturasController');
    Route::resource('inscripcions', 'InscripcionsController');

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
    
    //Reportes
    Route::get('admin/reports/excel',['as' => 'admin.reports.excel', 'uses'=>'ReportesController@getExcel']);

});



//********** inscripciones multiples o familiar  ****//

//agregar a la coleccion de cursos multiples para descuentos
Route::get('/inscripcions-add/{id}',['uses'=>'CalendarsController@getAddCurso', 'as'=>'inscripciones.addMultiples']);
//obtener la  coleccion
Route::get('/inscripcions-collections',['uses'=>'CalendarsController@getCursos','as'=>'inscripciones.multipleCursos']);
//eliminar un curso de la coleccion
Route::get('/inscripcions-collections/reduce/{id}',['uses'=>'CalendarsController@getRestarUno','as'=>'inscripciones.restarUno']);
//borrar la coleccion de cursos
Route::get('/inscripcions-collections/remove/{id}',['uses'=>'CalendarsController@getRestarCurso','as'=>'inscripciones.restarTodo']);





//********** Carrito ****//

//agregar al carrito
Route::get('/add-to-card/{id}',['uses'=>'CalendarsController@getAddToCart', 'as'=>'product.addToCart']);

//obtener el carrito
Route::get('/shopping-card',['uses'=>'CalendarsController@getCart','as'=>'product.shoppingCart']);

//eliminar uno del carrito
Route::get('/reduce/{id}',['uses'=>'CalendarsController@getReduceByOne','as'=>'product.reduceByOne']);

//borrar el carrito
Route::get('/remove/{id}',['uses'=>'CalendarsController@getRemoveItem','as'=>'product.remove']);

//realizar el pago
Route::get('/checkout',['uses'=>'CalendarsController@getCheckout','as'=>'checkout']);


Route::post('/checkout',['uses'=>'ProductController@postCheckout', 'as'=>'checkout','middleware'=>'auth']);


