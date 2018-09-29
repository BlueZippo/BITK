<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/', 'PagesController@index')->name('home');


Route::group(['middleware' => ['auth']], function() {
	Route::resource('roles', 'RoleController');
	Route::resource('users', 'UserController');
	Route::resource('stacks', 'StacksController');
	Route::resource('categories', 'CategoriesController');	
});

Route::resource('permissions', 'PermissionController');

Route::get('/register', 'RegistrationController@create');

Route::post('/register', 'RegistrationController@store')->name('register');

Route::get('/login', 'SessionsController@create');

//Route::post('login', 'SessionsController@store');

Route::post('login', [ 'as' => 'login', 'uses' => 'SessionsController@store']);

Route::get('/logout', 'SessionsController@destroy');

//Route::get('/stacks/create', 'StacksController@create');

//Route::post('/stacks', 'StacksController@store');

//Route::get('/stacks/{id}/follow', 'StacksController@follow');

// OAuth Routes
Route::get('auth/{provider}', 'Auth\AuthController@redirectToProvider');

Route::get('auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::resource('links', 'LinksController');
Route::resource('tags', 'TagsController');
//Route::resource('categories', 'CategoriesController');

Route::get('stacks/{id}/follow', 'StacksController@follow');
Route::get('stacks/{id}/unfollow', 'StacksController@unfollow');

Route::get('stacks/{id}/dashboard', 'StacksController@dashboard');
