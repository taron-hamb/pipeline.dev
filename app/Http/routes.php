<?php

get('/', 'WelcomeController@index');
post('/login', 'UserController@login');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);


Route::group(['middleware' => 'auth'], function() {
	get('/', 'HomeController@index');
//	get('/home', 'HomeController@index');
});
