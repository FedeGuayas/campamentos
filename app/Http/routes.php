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

Route::get('/', 'WelcomeController@welcome');

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
Route::group(['middleware' => ['auth','role:administrator|signup|planner|supervisor|invited'], 'prefix' => 'admin'], function () {
//Route::group(['prefix' => 'admin'], function () {

    //borrar
    Route::get('index', ['as' => 'admin.index', function () {
        return view('layouts.admin.index');
    }]);

    //*****SELECT DINAMICOS para crear inscripcion****//

    //obtener los alumnos de un trabajador
    Route::get('inscripcions/alumnos/{representante_id}','RepresentantesController@getAlumnos');
    //obtener los escenarios para un modulo  para select dinamico
    Route::get('inscripcions/escenarios/{modulo_id}','ProgramsController@getEscenarios');
    //obtener las disciplina para un escenario  para select dinamico
    //    Route::get('inscripcions/disciplinas/{escenario_id}','ProgramsController@getDisciplinas');
    Route::get('inscripcions/disciplinas/{data?}','ProgramsController@getDisciplinas');
    //obtener los dias para un programa, data defien al programa(esc,disc,modulo)
    Route::get('inscripcions/dias/{data?}',['uses'=>'CalendarsController@getDias','as'=>'program.getDias']);
    //obtener los horarios para el dia
    Route::get('inscripcions/horario/{data?}','CalendarsController@getHorario');
    //obtener los niveles para el dia y horario
    Route::get('inscripcions/nivel/{data?}','CalendarsController@getNivel');
    //obtener ontener el id del calendario o curso
    Route::get('inscripcions/curso/{data?}','CalendarsController@getCurso');
    //*****Actualizar costo de inscripcion****//
    Route::get('inscripcions/costo/{data?}','InscripcionsController@costoUpdate');


    //*****SELECT DINAMICOS para reporte general****//

    //obtener los escenarios para un modulo  para select dinamico
    Route::get('reports/escenarios/{modulo_id}','ProgramsController@getEscenarios');
    //obtener las disciplina para un escenario  para select dinamico
    Route::get('reports/disciplinas/{data?}','ProgramsController@getDisciplinas');
    //obtener los horarios para para un curso
    Route::get('reports/horario/{data?}','ReportesController@getHorario');
    

    //*****SELECT DINAMICOS para editar inscripcion****//
    
    //obtener los escenarios para un modulo de la inscripcion seleecionada
    Route::get('inscripcions/{insc}/escenarios/{modulo_id}','ProgramsController@updateEscenarios');
    //obtener las disciplina para un escenario  para select dinamico
    Route::get('inscripcions/{insc}/disciplinas/{data?}','ProgramsController@getDisciplinas');
    //obtener los horarios para el dia
    Route::get('inscripcions/{insc}/horario/{data?}','ReportesController@getHorario');

    //buscar el curso para editar inscripcion
    Route::get('inscripcions/listCurso/{data?}',['as' => 'admin.inscripcions.listCurso', 'uses'=>'InscripcionsController@searchCurso']);

    //cambiar el curso de la inscripcion actual
    Route::get('inscripcions/{insc}/curso/{data?}',['as' => 'admin.inscripcions.curso.update', 'uses'=>'InscripcionsController@updateCurso']);

    
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
    Route::get('alumnos/create{representante?}',['as' => 'admin.alumnos.create', 'uses'=>'AlumnosController@create']);

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

    //obtener todos los alumnos, representantes, inscripciones, comprobantes para el datatables con ajax
    Route::get('/alumnos/get',['as' => 'admin.alumnos', 'uses'=>'AlumnosController@getAll']);
    Route::get('/representantes/get',['as' => 'admin.representantes', 'uses'=>'RepresentantesController@getAll']);
    Route::get('/inscripciones/get',['as' => 'admin.inscripcions', 'uses'=>'InscripcionsController@getAll']);
    Route::get('/facturas/get',['as' => 'admin.facturas', 'uses'=>'FacturasController@getAll']);
    
    //permite eliminar alumnos  representantes, inscripciones, comprobantes  con botones en datatable con ajax, paginando
    Route::get('alumnos/{alumno?}/delete',['as' => 'admin.alumnos.delete', 'uses'=>'AlumnosController@destroy']);
    Route::get('representante/{representante?}/delete',['as' => 'admin.representante.delete', 'uses'=>'RepresentantesController@destroy']);
    Route::get('inscripcion/delete/{inscripcion?}/',['as' => 'admin.inscripcions.delete', 'uses'=>'InscripcionsController@destroy']);
    Route::get('facturas/delete/{comprobante?}/',['as' => 'admin.facturas.delete', 'uses'=>'FacturasController@destroy']);
    
    
    //eliminar curso
    Route::get('calendars/delete/{id?}/',['as' => 'admin.calendars.delete', 'uses'=>'CalendarsController@destroy']);

    //reinscripcion
    Route::get('inscripcion/re-inscribir/{id?}/',['as' => 'admin.inscripcions.re-inscribir', 'uses'=>'InscripcionsController@reInscribirGet']);
    Route::post('inscripcions/new/{data?}',['as' => 'admin.re_inscripcions.curso.store', 'uses'=>'InscripcionsController@storeNewCurso']);
    
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
    Route::resource('profesors', 'ProfesorsController');

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
    Route::get('/reports/excel',['as' => 'admin.reports.excel', 'uses'=>'ReportesController@getExcel']);
    Route::get('/reports/excel/export',['as' => 'admin.reports.exportExcel', 'uses'=>'ReportesController@exportExcel']);
    Route::get('/reports/personalizado',['as' => 'admin.reports.personalizado', 'uses'=>'ReportesController@getPersonal']);
    Route::get('/reports/excel/export/custom',['as' => 'admin.reports.exportPersonalizado', 'uses'=>'ReportesController@exportPersonal']);
    Route::get('/reports/general{data?}',['as' => 'admin.reports.general', 'uses'=>'ReportesController@getGeneral']);
    Route::get('/reports/export/general',['as' => 'admin.reports.exportGeneral', 'uses'=>'ReportesController@exportGeneral']);
    Route::get('/reports/pdf/{id}',['as' => 'admin.reports.pdf', 'uses'=>'ReportesController@inscripcionPDF']);
    Route::get('reports/pagos/cuadre', ['as'=>'admin.pagos.cuadre','uses'=>'ReportesController@cuadre']);
    Route::get('/reports/credenciales',['as' => 'admin.reports.credenciales', 'uses'=>'ReportesController@getCredenciales']);
    Route::get('/reports/credenciales/export',['as' => 'admin.reports.export-credenciales', 'uses'=>'ReportesController@exportCredenciales']);
    Route::get('/reports/resumen',['as' => 'admin.reports.resumen', 'uses'=>'ReportesController@getResumen']);
    Route::get('/reports/factura',['as' => 'admin.reports.factura', 'uses'=>'ReportesController@getFactura']);
    Route::get('/reports/factura/export',['as' => 'admin.reports.exportFactura', 'uses'=>'ReportesController@exportFactura']);

    //facturacion diaria usuario
    Route::get('/user/facturas/excel',['as' => 'admin.facturas.excel', 'uses'=>'UsersController@getFacturaExcel']);
    Route::get('/user/facturas/export',['as' => 'admin.facturas.exportExcel', 'uses'=>'UsersController@exportFacturaExcel']);
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


//*************Usuarios Online******************************//

/*Route group user is forces by middeware auth and role register*/
Route::group(['middleware' => ['auth','role:register'], 'prefix' => 'user'], function () {

    //vista para editar la contraseña del perfil de usuario
    Route::get('/password/edit', ['uses' => 'UsersController@getPasswordEdit','as' => 'user.password.edit']);
    //actualizar la contraseña del perfil de usuario
    Route::put('{user}/profile/pass/edit', ['uses' => 'UsersController@postPassword','as' => 'user.password.update']);
    //actualizar la contraseña del perfil de usuario
    Route::post('{user}/edit', ['uses' => 'UsersController@updateOnline','as' => 'user.update']);
    //Crear representantes  del  usuario logueado
    Route::post('/representante/create', ['uses' => 'HomeController@storeRepresentante','as' => 'user.representante.store']);
    //actualizar el representante del usuario online
    Route::PUT('/representante/{representante}/edit/', ['uses' => 'HomeController@updateRepresentante','as' => 'user.representante.update']);
    //eliminar el representante del usuario online
    Route::get('/representante/{representante}/delete/', ['uses' => 'HomeController@destroyRepresentante','as' => 'user.representante.destroy']);
    //Crear alumnos  del  usuario logueado
    Route::post('/representante/{representante}/alumno/create', ['uses' => 'HomeController@storeAlumno','as' => 'user.alumno.store']);
    //actualizar alumno online
    Route::PUT('/alumno/{alumno}/edit/', ['uses' => 'HomeController@updateAlumno','as' => 'user.alumno.update']);
    //eliminar el alumno
    Route::get('/alumno/{alumno}/delete/', ['uses' => 'HomeController@destroyAlumno','as' => 'user.alumno.destroy']);
    
});


//********** Carrito ****//
/*
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

*/