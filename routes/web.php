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

	Route::get('stacks/popular', 'StacksController@popular');
	Route::get('stacks/new', 'StacksController@new');
	Route::get('stacks/trending', 'StacksController@trending');
	Route::get('stacks/top-voted', 'StacksController@top');
	Route::get('stacks/top-thread', 'StacksController@thread');
	Route::get('stacks/following', 'StacksController@following');
	Route::get('stacks/my', 'StacksController@my');
	Route::get('stacks/new-people', 'StacksController@people');
	Route::get('stacks/trending-people', 'StacksController@people_trending');
	Route::get('stacks/top-people', 'StacksController@people_top');
	Route::get('stacks/following-people', 'StacksController@people_following');
	Route::get('stacks/my-profile', 'StacksController@myprofile');

	Route::post('stacks/upload', 'StacksController@upload');
	Route::post('stacks/trash', 'StacksController@trash');

	Route::get('stacks/explore', 'StacksController@explore');

	Route::get('stacks/view-all', 'StacksController@view_all');

	Route::post('stacks/autosave', 'StacksController@autosave');
	Route::post('stacks/delete', 'StacksController@delete');

	Route::post('stacks/{id}/update', 'StacksController@update');

	Route::post('stacks/{id}/vote',   'StacksController@vote');

	Route::resource('admin/users', 'UserController');

	//Route::post('stacks/{id}', 'StacksController@update');

	Route::get('/stacks/{id}/clone', 'StacksController@clone');

	Route::get('stacks/{id}/edit/{media}', 'StacksController@edit');

	Route::get('stacks/{page}/more', 'StacksController@more');
	Route::get('stacks/{id}/preview', 'StacksController@preview');

	Route::resource('stacks', 'StacksController');

	Route::resource('admin/categories', 'CategoriesController');

	Route::resource('admin/media_types', 'MediaTypeController');

	Route::post('links/get-meta-tags', 'LinksController@get_meta_tags');

	Route::post('links/addreminder', ['as' => 'links.addreminder', 'uses' => 'LinksController@addreminder']);

	Route::post('links/store', 'LinksController@store');

	Route::post('links/delete', 'LinksController@destroy');

	Route::resource('links', 'LinksController');

	Route::resource('admin/search', 'SearchController');

	Route::get('admin/links/parser', ['as' => 'admin.links.parser', 'uses' => 'AdminLinksController@parser']);
	
	Route::post('admin/links/store', ['as' => 'admin.links.store', 'uses' => 'AdminLinksController@store']);

	Route::patch('admin/links/{id}/update',['as' => 'admin.links.update', 'uses' => 'AdminLinksController@update']);

	Route::resource('admin/links', 'AdminLinksController');

	Route::get('admin/links/create', ['as' => 'admin.links.create', 'uses' => 'AdminLinksController@create']);

	
});

Route::resource('permissions', 'PermissionController');

Route::resource('people', 'PeopleController');

Route::get('person/{id}', 'PeopleController@person');

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

Route::get('stacks/{id}/like', 'StacksController@like');
Route::get('stacks/{id}/unlike', 'StacksController@unlike');
Route::get('stacks/{id}/hide', 'StacksController@hide');


Route::get('stacks/{id}/comments', 'StacksController@comments');

Route::get('stacks/{id}/dashboard', 'StacksController@dashboard');

Route::get('stacks/{id}/category', 'StacksController@category');

Route::post('stacks/search', 'StacksController@search');

Route::get('link_comments/{id}/comments', 'LinkCommentsController@show');
Route::post('link_comments/store', 'LinkCommentsController@store');
Route::resource('link_comments', 'LinkCommentsController');


Route::get('people/{id}/follow', 'PeopleController@follow');
Route::get('people/{id}/unfollow', 'PeopleController@unfollow');
Route::get('people/{id}/stacks', 'PeopleController@stacks');

Route::post('stack_comments/store', 'StackCommentsController@store');
Route::resource('stack_comments', 'StackCommentsController');


Route::get('s/popular', 'PublicController@popular');
Route::get('s/new', 'PublicController@new');
Route::get('s/trending', 'PublicController@trending');
Route::get('s/top-voted', 'PublicController@top');
Route::get('s/top-thread', 'PublicController@thread');
Route::get('s/following', 'PublicController@following');
Route::get('s/new-people', 'PublicController@people');
Route::get('s/trending-people', 'PublicController@people_trending');
Route::get('s/top-people', 'PublicController@people_top');
Route::get('s/following-people', 'PublicController@people_following');

Route::get('/x/{code}', 'LinksController@long_code');
