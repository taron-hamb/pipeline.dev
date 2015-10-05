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
	get('/desk-performance/{id?}',  'HomeController@deskPerformance');
	get('/deal/{id}',  'HomeController@dealDetails');
});
