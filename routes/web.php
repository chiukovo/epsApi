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


//student api
Route::group(['prefix' => 'api'], function () {
	Route::group(['prefix' => 'student'], function () {
		Route::get('introduction', 'Student\ApiController@introduction');
		Route::get('education', 'Student\ApiController@education');
		Route::get('work', 'Student\ApiController@work');
		Route::get('web', 'Student\ApiController@web');
	});
});
