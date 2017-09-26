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
        Route::get('activity', 'Student\ApiController@activity');
        Route::get('workCourse', 'Student\ApiController@workCourse');
        Route::get('honoraryRecord', 'Student\ApiController@honoraryRecord');
        Route::get('workProject', 'Student\ApiController@workProject');
        Route::get('myGalleryDetail', 'Student\ApiController@myGalleryDetail');
        Route::get('myGallery', 'Student\ApiController@myGallery');
        Route::get('earlyWarning', 'Student\ApiController@earlyWarning');
		Route::get('shareSearch', 'Student\ApiController@shareSearch');
	});
});