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

use Illuminate\Http\Request;

Route::post('/user/login', 'User\Auth\LoginController@login')->name('session.user-login');

// Secure APIs
// Route::group([], function () {
Route::group(['middleware' => ['auth:api']], function () {

    $this->post('/order', 'User\OrderController@index')->name('pizza.order');

    $this->get('/pizzas', 'User\PizzasController@index')->name('pizzas.get-all');

});


