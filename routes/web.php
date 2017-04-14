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
    return Redirect('/login');
});

Auth::routes();

Route::get('/home',['as'=>'get.Member', 'uses' => 'HomeController@index']);
Route::get('/list',['as'=>'get.list', 'uses'=> 'MemberController@getList']);
Route::post('/add',['as'=>'post.add', 'uses'=> 'MemberController@getAdd']);
Route::get('/edit/{id}',['as'=>'get.edit', 'uses'=> 'MemberController@getEdit']);
Route::post('/edit/{id}',['as'=>'post.edit', 'uses'=> 'MemberController@postEdit']);
Route::delete('/delete/{id}',['as'=>'post.delete', 'uses'=> 'MemberController@deleteMember']);
Route::post('/upload',['as'=>'post.upload', 'uses'=> 'MemberController@uploadImage']);

