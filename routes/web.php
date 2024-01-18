<?php

use Illuminate\Support\Facades\Route;

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


// routes/web.php
// Auth::routes();



// Route::group(['middleware' => ['guest']], function () {
//     Route::get('/', function () {
//         return view('auth.login');
//     });
// });

Route::get('/', 'HomeController@index')->name('selection');


Route::group(['namespace' => 'Auth'], function () {

Route::get('/login/{type}','LoginController@loginForm')->middleware('guest')->name('login.show');

Route::post('/login','LoginController@login')->name('login');

Route::get('/logout/{type}', 'LoginController@logout')->name('logout');

});


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth']
    ], function () { //...
        //     Route::get('/', function()
        // {
        //     return view('dashboard');
        // });
        Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
        Route::group(['namespace' => 'Grades'], function () {
            Route::resource('grades', 'GradesController');
        });
        //   Classrooms
        Route::group(['namespace' => 'Classroom'], function () {
            Route::resource('Classrooms', 'ClassroomController');
            Route::post('delete_all', 'ClassroomController@delete_all')->name('delete_all');
            Route::post('Filter_Classes', 'ClassroomController@Filter_Classes')->name('Filter_Classes');
        });

        Route::group(['namespace' => 'Sections'], function () {

            Route::resource('Sections', 'SectionsController');

            Route::get('/classes/{id}', 'SectionsController@getclasses');
        });

        Route::view('add_parent', 'livewire.show_form')->name('add_parent');

        /**---------------------------------------------------------- */
        Route::group(['namespace' => 'Teachers'], function () {
            Route::resource('Teachers', 'TeacherController');
        });
        /**---------------------------Studnets------------------------------- */
        Route::group(['namespace' => 'Students'], function () {
            Route::resource('Students', 'StudentController');
            Route::resource('Fees','FeesController');
            Route::resource('Fees_Invoices','FeesInvoicesController');
            Route::resource('receipt_students','ReceiptStudentsController');
            Route::resource('ProcessingFee','ProcessingFeeController');
            Route::resource('Payment_students','PaymentController');
            Route::resource('Attendance','AttendanceController');
            Route::resource('library','LibraryController');
            Route::resource("Graduated",'GraduteStudents');
            Route::get("downloadAttachment/{file_name}",'LibraryController@downloadAttachment')->name('downloadAttachment');;
            Route::resource("Promotion",'PromtionController');
            Route::resource('online_classes', 'OnlineClasseController');
            Route::post('Upload_attachment','StudentController@Upload_attachment')->name('Upload_attachment');
            Route::get('Download_attachment/{studentname}/{filename}','StudentController@Download_attachment')->name('Download_attachment');
            Route::post('Delete_attachment','StudentController@Delete_attachment')->name('Delete_attachment');

        });
        //----------------------------Exams--------------------------------
        Route::group(['namespace'=>'Exams'],function(){
            Route::resource('Exams', 'ExamController');
        });
//-------------------------------Subject---------------------------
        Route::group(['namespace'=>'Subject'],function(){
            Route::resource('subjects', 'SubjectController');
        });
          //==============================Quizzes============================
        Route::group(['namespace' => 'Quizzes'], function () {
            Route::resource('Quizzes', 'QuizzesController');
        });
        Route::resource('settings','SettingController');
    });
/** OTHER PAGES THAT SHOULD NOT BE LOCALIZED **/



