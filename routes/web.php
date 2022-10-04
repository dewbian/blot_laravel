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
    return view('welcome');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');




 Route::get('/social/{provider}', [
       'as' => 'social.login',
     'uses' => 'Auth\SocialController@redirectToProvider',
 ]);


//Route::get('/social/{provider}' , 'Auth\SocialController@redirectToProvider');

Route::get('/social/{provider}/callback','Auth\SocialController@handleProviderCallback');

//Route::get('login/github/callback', 'Auth\LoginController@handleProviderCallback');



 

Route::view('/social/invalid', 'auth.social.invalid');