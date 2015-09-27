<?php


get('/', 'WelcomeController@index');
post('/login', 'UserController@login');


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
get('/home', 'HomeController@index');

Route::group(['middleware' => 'auth'], function() {

//	get('/', 'UserController@index');

});
