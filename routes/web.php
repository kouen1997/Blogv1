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

Route::get('/', 'HomeController@getHome');

Route::get('/videos', 'HomeController@getVideos');

Route::get('/blog/{slug}', 'BlogController@getViewBlog');


Route::get('/login', array('as' => 'signup','uses' => 'Auth\LoginController@getLogin'));
Route::post('/login', 'Auth\LoginController@postLogin');

Route::get('/logout', array('as' => 'logout','uses' => 'Auth\LoginController@logout'));

// # Socialite -- #

Route::get('/login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('/login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('/register', array('as' => 'register','uses' => 'Auth\RegisterController@getRegister'));
Route::post('/register', 'Auth\RegisterController@postRegister');

// # Admin -- #

Route::get('/admin/dashboard', 'AdminController@dashboard')->name('home');

Route::get('/admin/profile', 'AdminController@getProfile');

// # Blog -- #

Route::get('/admin/blog', 'AdminController@getBlog');

Route::get('/blog-listing-data', 'AdminController@getAdminBlogData');

Route::get('/admin/add/blog', 'AdminController@getAddBlog');

Route::post('/admin/add/blog', 'AdminController@postAddBlog');

Route::get('/admin/edit/blog/{blog_id}', 'AdminController@getEditBlog');

Route::post('/admin/edit/blog/{blog_id}', 'AdminController@postEditBlog');

Route::post('/blog/{blog_id}/delete', 'AdminController@postDeleteBlog');


// # To do -- #

Route::get('/admin/todo', 'AdminController@getTodo');

Route::get('/todo-data', 'AdminController@getTodoData');

Route::post('/add-todo', 'AdminController@postAddTodo');

Route::post('/checked-todo/{task_id}', 'AdminController@postCheckedTodo');

Route::post('/delete-todo/{task_id}', 'AdminController@postDeleteTodo');

Route::post('/edit-todo/{task_id}', 'AdminController@postEditTodo');

