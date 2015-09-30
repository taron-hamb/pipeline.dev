<?php

get('/', 'WelcomeController@index');

post('/authenticate', 'UserController@authenticate');

get('/auth/register', function(){
	return redirect('/');
});

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::group(['middleware' => 'auth'], function() {
	get('/dashboard',  'HomeController@index');
	get('/desk-performance',  'HomeController@deskPerformance');
	get('/user-desk/{id}',  'HomeController@userDesk');
});
