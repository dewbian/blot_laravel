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

Route::post('/upload', 'UploadController@upload') -> name("upload");
Route::get('/page', 'UploadController@page') -> name("page11");


Route::get('/', function () {
   return view('welcome');
});

/* 관리자페이지 */
//Route::middleware(['auth'])->name('userinfo.')->prefix('userinfo')->group(function () {
Route::prefix('master')->group(function () {

    Route::get('/',                 function(){   return view('master.master_layout');      });
    Route::get('/cont_portfolio',   function(){   return view('master.cont_portfolio');     });
    


    //Route::get('/', [UserController::class, 'show'])->name('show');
    // Route::get('/picDelete', [UserController::class, 'picDelete'])->name('picDelete');
    // Route::delete('/{id}/delete', [UserController::class, 'delete'])->name('delete');
    // Route::post('/', [UserController::class, 'store'])->name('store');
    // Route::PATCH('/{id}', [UserController::class, 'update'])->name('update');
});


/* 에디터 업로드 */
Route::post('/editor/upload', 'ImageUploader@upload');
//Route::post('/editor/upload', [ImageUploader::class, 'upload']) -> name('imgUpload');

Route::post('/store', 'EditorUploader@store'); 
Auth::routes();
/*

Route::post('/editor/upload', 'ImageUploader@upload');


Route::get('/home', 'HomeController@index')->name('home');

Route::get('/logout', function(){
   // return view('welcome');
});

Route::get('/admin', function(){
    //return view('admin');
    return 'Usdddddr';
});


Route::get('/master', function(){
    return view('master.master_layout');
    //return 'Usdddddr';
});

 Route::get('/social/{provider}', [
    'as' => 'social.login',
    'uses' => 'Auth\SocialController@redirectToProvider',
 ]);
 Route::get('users/{id}', function($id)
 {
     return 'User '.$id;
 });


Route::get('/social/{provider}/callback','Auth\SocialController@handleProviderCallback');

Route::view('/social/invalid', 'auth.social.invalid');

*/