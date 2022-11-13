<?php 

Route::get('/login',        'App\Http\Controllers\Admin\AdminLoginController@showLoginForm' )-> name('login');
Route::post('/login',       'App\Http\Controllers\Admin\AdminLoginController@login'         )-> name('login.submit');
Route::get('logout/',       'App\Http\Controllers\Admin\AdminLoginController@logout'        )-> name('logout');
Route::get('/',             'App\Http\Controllers\Admin\DashboardController@dashboard'      )-> name('dashboard');
