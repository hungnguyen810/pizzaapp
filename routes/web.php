<?php

/*
|--------------------------------------------------------------------------
| Web Users Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
Route::get('/', function () {
    return redirect('admin');
});

// TODO: delete in future, this is route just for test nearest properties
Route::get('/map', function () {
    return view('map');
});

//Admin Login
Route::get('admin/login', 'Admin\Auth\LoginController@showLoginForm');
Route::post('admin/login', 'Admin\Auth\LoginController@login');
Route::post('admin/logout', 'Admin\Auth\LoginController@logout');

//Admin Passwords
Route::post('admin/password/email', 'Admin\Auth\ForgotPasswordController@sendResetLinkEmail');
Route::post('admin/password/reset', 'Admin\Auth\ResetPasswordController@reset');
Route::get('admin/password/reset', 'Admin\Auth\ForgotPasswordController@showLinkRequestForm');
Route::get('admin/password/reset/{token}', 'Admin\Auth\ResetPasswordController@showResetForm');

