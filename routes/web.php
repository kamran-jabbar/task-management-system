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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
/* @todo: there can create group for this task related stuff. */
Route::get('/dashboard', 'HomeController@index')->name('home');
Route::get('/create-task', 'TaskController@createForm');
Route::post('/create-task', 'TaskController@store');
Route::get('/delete-task/{id}', 'TaskController@delete');
Route::get('/start-task/{id}', 'TaskController@start');
Route::get('/finish-task/{id}', 'TaskController@finish');