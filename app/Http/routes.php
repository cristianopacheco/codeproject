<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('app');
});

Route::post('oauth/access_token', function() {
    return Response::json(Authorizer::issueAccessToken());
});

Route::group(['middleware'=>'oauth'], function(){
    
    Route::resource('client','ClientController',['except'=>['create','edit']]);

    Route::resource('project','ProjectController',['except'=>['create','edit']]);

    Route::resource('project.member','ProjectMemberController',['except'=>['create','edit','update']]);

    Route::group(['middleware' => 'check.project.permission','prefix'=>'project'],function(){
        
        // Project
        Route::get('/{id}/members','ProjectController@members');
        
        // ProjectNote
        Route::get('{id}/note','ProjectNoteController@index');
        Route::post('{id}/note','ProjectNoteController@store');
        Route::get('{id}/note/{noteId}','ProjectNoteController@show');
        Route::put('{id}/note/{noteId}','ProjectNoteController@update');
        Route::delete('{id}/note/{noteId}','ProjectNoteController@destroy');
        
        // ProjectFile
        Route::get('{id}/file','ProjectFileController@index');
        Route::get('{id}/file/{fileId}','ProjectFileController@show');
        Route::get('{id}/file/{fileId}/download','ProjectFileController@showFile');
        Route::post('{id}/file','ProjectFileController@store');
        Route::put('{id}/file/{fileId}','ProjectFileController@update');
        Route::delete('{id}/file/{fileId}','ProjectFileController@destroy');
        
        //ProjectTask
        Route::get('{id}/task','ProjectTaskController@index');
        Route::post('{id}/task','ProjectTaskController@store');
        Route::get('/{id}/task/{taskId}','ProjectTaskController@show');
        Route::put('/{id}/task/{taskId}','ProjectTaskController@update');
        Route::delete('/{id}/task/{taskId}','ProjectTaskController@destroy');
        
        
        
    });
    
    Route::get('user/authenticated','UserController@authenticated');
    Route::resource('user','UserController',['except'=>['create','edit','store']]);
});



