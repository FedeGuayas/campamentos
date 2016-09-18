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


/*Front end for register online */
Route::get('front', function () {
    return view('layouts/front');
});


/*OK*/
/*Route group admin, and login is forces by middeware auth*/
//Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
Route::group(['prefix' => 'admin'], function () {

    Route::get('index', [
        'as' => 'admin.index', function () {
        return view('layouts.admin.index');
    }]);

});



