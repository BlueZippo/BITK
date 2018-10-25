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

Route::get('/', 'PublicController@index')->name('home');

Route::get('/dashboard', 'PagesController@index')->name('home');


Route::group(['middleware' => ['auth']], function() 
{
	Route::resource('admin/roles', 'RoleController');

	Route::post('users/image-upload', 'UserController@upload');

	Route::post('users/background', 'UserController@background');

	Route::post('users/profile/update',  ['as' => 'users.profile_update', 'uses' => 'UserController@profile_update']);
	
	Route::get('users/profile', ['as' => 'users.profile', 'uses' => 'UserController@profile']);	

	Route::get('stacks/explore', 'StacksController@explore');

	

	Route::get('stacks/view-all', 'StacksController@view_all');

	

	Route::post('stacks/{id}/update', 'StacksController@update');

	Route::post('stacks/{id}/vote',   'StacksController@vote');

	Route::resource('admin/users', 'UserController');

	Route::resource('stacks', 'StacksController');

	Route::resource('admin/categories', 'CategoriesController');	

	Route::post('links/get-meta-tags', 'LinksController@get_meta_tags');

	Route::post('links/addreminder', ['as' => 'links.addreminder', 'uses' => 'LinksController@addreminder']);

	Route::resource('links', 'LinksController');

	Route::resource('admin/search', 'SearchController');


});

Route::resource('permissions', 'PermissionController');

Route::resource('people', 'PeopleController');

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


Route::resource('tags', 'TagsController');
Route::get('/tags/{id}/delete', 'TagsController@destroy');
//Route::resource('categories', 'CategoriesController');

Route::get('stacks/{id}/follow', 'StacksController@follow');
Route::get('stacks/{id}/unfollow', 'StacksController@unfollow');

Route::get('stacks/{id}/dashboard', 'StacksController@dashboard');

Route::get('stacks/{id}/category', 'StacksController@category');
Route::post('stacks/search', 'StacksController@search');


Route::get('people/{id}/follow', 'PeopleController@follow');
Route::get('people/{id}/unfollow', 'PeopleController@unfollow');
Route::get('people/{id}/stacks', 'PeopleController@stacks');


