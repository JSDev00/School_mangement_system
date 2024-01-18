<?php

use Illuminate\Support\Facades\Route;
use App\Models\Teachers;
use App\Models\Students;
//==============================Translate all pages============================
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth:teacher']
    ], function () {

    //==============================dashboard============================
    Route::get('/teacher/dashboard', function () {
        $ids = Teachers::findOrFail(auth()->user()->id)->Sections()->pluck('sections_id');
        // return $ids;
        $count_sections = $ids->count();
        $count_students = Students::whereIn('section_id',$ids)->count();
        return view('pages.Teachers.dashboard',compact('count_students','count_sections'));
    });

    //===================================================================

    Route::group(['namespace'=>'Teachers\dashboard'],function(){
        Route::get('students','StudentsController@index')->name('students.index');
        Route::get('sections','StudentsController@sections')->name('sections');
        Route::post('attendance','StudentsController@attendance')->name('attendance');
        Route::post('edit_attendance','StudentsController@editAttendance')->name('attendanceEdit');
        Route::get('attendanceReport','StudentsController@attendence_report')->name('attendanceReport');
        Route::post('attendance.search','StudentsController@attendanceSearch')->name('attendance.search');
        Route::resource('quizzes','QuizzController');
        Route::resource('questions', 'QuestionsController');
        Route::get('profile', 'ProfileController@index')->name('profile.show');
        Route::post('profile/{id}', 'ProfileController@update')->name('profile.update');
    });
});
