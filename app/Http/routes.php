<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::get('/', 'HomeController@index');
    Route::get('/contact', 'HomeController@contact');
    Route::post('/message', 'HomeController@createContactMessage');
    
    Route::get('/tasks', 'TaskController@index');
    Route::get('/tasks/show/{alias}', 'TaskController@index');
    Route::get('/search/{search}', 'TaskController@search');

});

Route::group(['middleware' => 'web'], function () {
    Route::auth();
    Route::get('/home', 'HomeController@index');

    Route::get('tasks/create', ['middleware' => 'auth', 'uses' => 'TaskController@getCreateView']);
    Route::post('tasks/createOrEdit', ['middleware' => 'auth', 'uses' => 'TaskController@createOrEdit']);
    Route::get('tasks/edit/{id}', ['middleware' => 'auth', 'uses' => 'TaskController@getEditView']);
    Route::get('tasks/delete/{id}', ['middleware' => 'auth', 'uses' => 'TaskController@getDeleteView']);
    Route::post('tasks/delete', ['middleware' => 'auth', 'uses' => 'TaskController@delete']);
    Route::get('tasks/file/{id}', 'TaskController@viewTaskFile');
    
    
    Route::get('solution/create/{id}', ['middleware' => 'auth', 'uses' => 'SolutionController@getCreateView']);
    Route::post('solution/createOrEdit', ['middleware' => 'auth', 'uses' => 'SolutionController@createOrEdit']);
    Route::get('solution/edit/{id}', ['middleware' => 'auth', 'uses' => 'SolutionController@getEditView']);
    Route::get('solution/delete/{id}', ['middleware' => 'auth', 'uses' => 'SolutionController@getDeleteView']);
    Route::post('solution/delete', ['middleware' => 'auth', 'uses' => 'SolutionController@delete']);
    Route::get('solution/file/{id}', 'SolutionController@viewSolutionFile');
    
    Route::get('/account', ['middleware' => 'auth', 'uses' => 'UserController@account']);
    Route::get('/account/change/email', ['middleware' => 'auth', 'uses' => 'UserController@getChangeEmailView']);
    Route::post('/account/change/email', ['middleware' => 'auth', 'uses' => 'UserController@changeEmail']);
    Route::get('/account/change/name', ['middleware' => 'auth', 'uses' => 'UserController@getChangeNameView']);
    Route::post('/account/change/name', ['middleware' => 'auth', 'uses' => 'UserController@changeName']);
    Route::get('/account/change/password', ['middleware' => 'auth', 'uses' => 'UserController@getChangePasswordView']);
    Route::post('/account/change/password', ['middleware' => 'auth', 'uses' => 'UserController@changePassword']);
        
    Route::get('/my/tasks', ['middleware' => 'auth', 'uses' => 'UserController@tasks']);
    Route::get('/my/solutions', ['middleware' => 'auth', 'uses' => 'UserController@solutions']);
    
    Route::group(['middleware' => ['auth','admin']], function () {
    
        Route::get('/admin', ['uses' => 'AdminController@messages']);
        Route::get('/admin/messages', ['uses' => 'AdminController@messages']);
        Route::get('/admin/users', ['uses' => 'AdminController@users']);
        Route::get('/admin/logs', ['uses' => '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index']);

    });
    
});
