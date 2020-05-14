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

Route::get('professors', 'ProfessorController@index')->name('professors.index');
Route::get('professors/{professor}', 'ProfessorController@show')->name('professors.show');
Route::post('professors/professor_courses', 'ProfessorController@professor_courses')->name('professors.professor_courses');


Route::group(['middleware' => ['verified']], function () {
    Route::get('profile', 'ProfileController@show')->name('profile.show');
    Route::post('profile', 'ProfileController@update')->name('profile.update');

    Route::group(['middleware' => ['can_recommend']], function () {
        Route::get('profile/enrolled', 'ProfileController@enrolled_page')->name('profile.enrolled_page');
        Route::post('profile/enrolled_courses', 'ProfileController@enrolled_courses')->name('profile.enrolled_courses');
        Route::get('profile/recommend', 'ProfileController@recommend')->name('profile.recommend');
    });

    Route::group(['middleware' => ['student']], function () {
        # ---------------- Survey for new student  -------------------
        Route::get('survey', 'SurveyController@show')->name('survey.show');
        Route::post('survey', 'SurveyController@update')->name('survey.update');

        Route::get('lectures/{lecture}', 'LectureController@show')->name('lectures.show');
        Route::get('courses/enroll/{course}', 'CourseController@enroll')->name('courses.enroll');

        # ---------------- Student's process -------------------
        Route::post('processes', 'ProcessController@store')->name('processes.store');
        Route::delete('processes', 'ProcessController@destroy')->name('processes.destroy');

        # ---------------- Student's reviews -------------------
        Route::get('reviews/{course}', 'ReviewController@index')->name('reviews.index');
        Route::post('reviews', 'ReviewController@store')->name('reviews.store');

    });
});
