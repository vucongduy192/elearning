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

// header('Access-Control-Allow-Origin:  *');
// header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
// header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');

Route::group(['namespace' => 'Api\Admin', 'prefix' => 'v0'], function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');

    Route::group(['middleware' => ['jwt.verify']], function () {
        Route::get('user', 'AuthController@getUser');
        Route::post('logout', 'AuthController@logout');
        
        Route::get('dashboards', 'DashboardController@index');
        Route::resource('categories', 'CategoryController');
        Route::resource('rules', 'RuleController');
        Route::post('rules/csv', 'RuleController@dumpCSV');
        Route::resource('users', 'UserController');
        Route::resource('teachers', 'TeacherController');
        Route::resource('students', 'StudentController');
        Route::resource('courses', 'CourseController');
        Route::get('durations', 'CourseController@getListDurations');
        Route::get('partners', 'CourseController@getListPartners');
        Route::resource('modules', 'ModuleController', ['only' => ['show', 'update']]);
        Route::resource('enrolls', 'EnrollController');
        Route::get('recommend_progress', 'EnrollController@getRecommendProgress');
        Route::post('enrolls/csv', 'EnrollController@dumpCSV');
        Route::post('configs/update', 'MatrixController@updateCoefficient');
        Route::post('configs/combine', 'MatrixController@combineMatrix');
        Route::get('configs/get_name_convert', 'ConfigController@getNameConvert');

        Route::get('configs', 'MatrixController@getConfig');
        Route::resource('blogs', 'BlogController');
        Route::post('blogs/upload_image', 'BlogController@uploadImagePost');
        Route::post('blogs/remove_image', 'BlogController@removeImagePost');
    });
});
