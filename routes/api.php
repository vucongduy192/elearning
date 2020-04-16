<?php
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['namespace' => 'Api\Admin', 'prefix' => 'v0'], function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');

    Route::group(['middleware' => ['jwt.verify']], function () {
        Route::get('user', 'AuthController@getUser');
        Route::post('logout', 'AuthController@logout');

        Route::resource('categories', 'CategoryController');
        Route::resource('rules', 'RuleController');
        Route::post('rules/csv', 'RuleController@dumpCSV');
        Route::resource('users', 'UserController');
        Route::resource('teachers', 'TeacherController');
        Route::resource('students', 'StudentController');
        Route::resource('courses', 'CourseController');
    });
});
