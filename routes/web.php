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

Route::get('/', function () {
    return view('index');
});

Route::post('/getcert', 'certificateController@logRequest')->name('certRequest');
Route::get('/certificate/{cert_id}','PDFgenerator@generate');
Route::get('view', function (){
    return view('certificates.cert1');
});

//Auth::routes();

Route::get('hng-admin-login', 'Auth\LoginController@showLoginForm')->name('hng-admin-login');
Route::post('hng-admin-login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('hng-admin-register', 'Auth\RegisterController@showRegistrationForm');
Route::post('hng-admin-register', 'Auth\RegisterController@register');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/change-download-status/{id}/{status}', 'HomeController@changeDownloadStatus');

Route::get('/verify-cert/{code}', 'certificateController@verify');
