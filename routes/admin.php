<?php

Route::get('/', function () {
    return view('admin.home');
});

Route::get('home', 'HomeController@index');

Route::resource('users', 'UsersController');
Route::patch('/users/{id}/update-password', 'UsersController@updatePassword');

Route::resource('/admin-users', 'AdminUsersController');
Route::resource('/pizzas', 'PizzasController');
Route::resource('/pizza-options', 'PizzaOptionsController');
Route::resource('/orders', 'OrdersController');