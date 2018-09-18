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

Route::get('/register', 'RegistrationController@create');

Route::post('/register', 'RegistrationController@store');

Route::get('/login', 'SessionsController@create');

//Route::post('login', 'SessionsController@store');

Route::post('login', [ 'as' => 'login', 'uses' => 'SessionsController@store']);

Route::get('/logout', 'SessionsController@destroy');

Route::get('/stacks/create', 'StacksController@create');

Route::post('/stacks', 'StacksController@store');

Route::get('/stacks/{id}/follow', 'StacksController@follow');

// OAuth Routes
Route::get('auth/{provider}', 'Auth\AuthController@redirectToProvider');

Route::get('auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback');

Route::resource('links', 'LinksController');
Route::resource('tags', 'TagsController');

Route::get('links/{id}/follow', 'LinksController@follow');
//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');