<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:teacher,web'], function () {
Route::get('/Get_classrooms/{id}', 'AjaxController@getClassrooms');
Route::get('/Get_Sections/{id}', 'AjaxController@Get_Sections');

});
