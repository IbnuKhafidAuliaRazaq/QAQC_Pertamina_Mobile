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

Route::get('welcome', function(){
    return view('welcome');
});

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth'])->group(function () {

    //  Print 
    Route::get('/print_surat/{id}', 'Controller@print_surat');
    Route::get('/print_berita/{id}', 'Controller@print_berita');
    Route::get('/print_endreport/{id}', 'Controller@print_report');
    Route::get('/print_request/{id}', 'Controller@print_request');

    // Setting
    Route::get('/settings', 'SettingController@index');
    Route::get('/settings/ubah', 'SettingController@ubah');
    Route::post('/settings/ubah', 'SettingController@updateprofile');
    Route::post('/settings/ubahpassword', 'SettingController@updatepassword');
    Route::get('/settings/upload', function(){
        return view('auth.upload');
    });
    Route::post('/settings/upload', 'SettingController@upload');
    // User
    Route::middleware(['user'])->group(function () {
        Route::get('/user', 'UserController@index');
        Route::get('/user/add', 'UserController@add');
        Route::get('/user/listinspection', 'UserController@listinspection');
        Route::post('/user/create', 'UserController@create')->name('user_create');
        Route::get('/user/view/{id}', 'UserController@view');
        Route::get('/user/delete/{id}', 'UserController@delete');
    });
    // Leader
    Route::middleware(['leader'])->group(function () {
        Route::get('/leader', 'LeaderController@index');
        Route::get('/leader/agenda', 'LeaderController@agenda');
        Route::get('/leader/{status}', 'LeaderController@request');
        Route::get('/leader/followup/{id}', 'LeaderController@followup');
        Route::get('/leader/view/{id}', 'LeaderController@view');
        Route::post('/leader/create_inspection/{id}', 'LeaderController@createinspection')->name('followup');
    });
    // Inspector 
     Route::middleware(['inspector'])->group(function () {
        Route::get('/inspector', 'InspectorController@index');
        Route::get('/inspector/{status}', 'InspectorController@inspection');
        Route::get('/inspector/view/{id}', 'InspectorController@view');
        Route::post('/inspector/add_topic/{id}', 'InspectorController@add_topic')->name('add_topic');
        Route::post('/inspector/add_report/{id}', 'InspectorController@add_report')->name('add_report');
        Route::post('/inspector/finish/{id}', 'InspectorController@finish')->name('finish');
        Route::post('/inspector/add_beritaacara/{id}', 'InspectorController@berita_acara');
    });
    // SeniorManager
    Route::middleware(['manager'])->group(function () {
        Route::get('/manager', 'SrManagerController@index');
        Route::get('/manager/request/{approval}', 'SrManagerController@request');
        Route::get('/manager/inspection/{approval}', 'SrManagerController@inspection');
        Route::get('/manager/view/{id}', 'SrManagerController@view');
        Route::get('/manager/view/ins/{id}', 'SrManagerController@view_ins');
        Route::post('/manager/approval/{id}', 'SrManagerController@approval')->name('approval');
        Route::post('/manager/approval_ins/{id}', 'SrManagerController@approval_ins')->name('approval_ins');
    });
   

});


Auth::routes();

