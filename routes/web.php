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

// Route::get('/admin', 'AdminController@index');

Route::group(['prefix' => 'admin'], function () {
    Route::get('{path?}', 'AdminController@index')->where('path', '[\/\w\.-]*')->name('admin');
});


Auth::routes(['verify' => true]);
Route::get('/', 'HomeController@index')->name('home');
Route::get('/errors', 'HomeController@errors')->name('errors');

Route::get('courses', 'CourseController@index')->name('courses.index');
Route::get('courses/{course}', 'CourseController@show')->name('courses.show');
Route::post('courses', 'CourseController@search')->name('courses.search');



Route::group(['middleware' => ['verified']], function () {
    Route::get('profile', 'ProfileController@show')->name('profile.show');
    Route::post('profile', 'ProfileController@update')->name('profile.update');

    Route::group(['middleware' => ['can_recommend']], function () {
        Route::get('profile/enrolled', 'ProfileController@enrolled')->name('profile.enrolled');
        Route::get('profile/recommend', 'ProfileController@recommend')->name('profile.recommend');
    });

    Route::group(['middleware' => ['student']], function () {
        Route::get('survey', 'SurveyController@show')->name('survey.show');
        Route::post('survey', 'SurveyController@update')->name('survey.update');

        Route::get('lectures/{lecture}', 'LectureController@show')->name('lectures.show');
        Route::get('courses/enroll/{course}', 'CourseController@enroll')->name('courses.enroll');
    });
});
