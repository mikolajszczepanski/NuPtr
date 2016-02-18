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
    Route::get('/home', 'HomeController@index');
    Route::get('/contact', 'HomeController@contact');
    Route::post('/message', 'HomeController@createContactMessage');
    
    Route::get('/tasks', 'TaskController@index');
    Route::get('/tasks/show/{alias}', 'TaskController@index');
    Route::get('/search/{search?}', 'TaskController@search');

    Route::get('/task/file/{id}', 'TaskController@viewTaskFile');
    Route::get('/task/view/{id}', 'TaskController@viewTask');
    
    Route::get('/solution/file/{id}', 'SolutionController@viewSolutionFile');
    
    Route::get('/api/get/file_template',function(){
        $view = View::make('public.file_template');
        $file_content = $view->render();
        return response()->json(['file' => $file_content]);
    });
    
    Route::auth();
});

Route::group(['middleware' => ['web','auth']], function () {;

    Route::get('/task/create', ['uses' => 'TaskController@getCreateView']);
    Route::post('/task/createOrEdit', ['uses' => 'TaskController@createOrEdit']);
    Route::get('/task/edit/{id}', ['uses' => 'TaskController@getEditView']);
    Route::get('/task/delete/{id}', ['uses' => 'TaskController@getDeleteView']);
    Route::post('/task/delete', ['uses' => 'TaskController@delete']);

    Route::get('/solution/create/{id}', ['uses' => 'SolutionController@getCreateView']);
    Route::post('/solution/createOrEdit', ['uses' => 'SolutionController@createOrEdit']);
    Route::get('/solution/edit/{id}', ['uses' => 'SolutionController@getEditView']);
    Route::get('/solution/delete/{id}', ['uses' => 'SolutionController@getDeleteView']);
    Route::post('/solution/delete', ['uses' => 'SolutionController@delete']);
    
    Route::get('/account', ['uses' => 'UserController@account']);
    Route::get('/account/change/email', [ 'uses' => 'UserController@getChangeEmailView']);
    Route::post('/account/change/email', ['uses' => 'UserController@changeEmail']);
    Route::get('/account/change/name', ['uses' => 'UserController@getChangeNameView']);
    Route::post('/account/change/name', ['uses' => 'UserController@changeName']);
    Route::get('/account/change/password', ['uses' => 'UserController@getChangePasswordView']);
    Route::post('/account/change/password', ['uses' => 'UserController@changePassword']);
        
    Route::get('/my/tasks', ['uses' => 'UserController@tasks']);
    Route::get('/my/solutions', ['uses' => 'UserController@solutions']);
    
    Route::group(['middleware' => ['admin']], function () {
    
        Route::get('/admin', ['uses' => 'AdminController@messages']);
        Route::get('/admin/messages', ['uses' => 'AdminController@messages']);
        Route::get('/admin/users', ['uses' => 'AdminController@users']);
        Route::get('/admin/logs', ['uses' => '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index']);

    });
    
});
