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
    return view('auth.login');
});

Auth::routes();


//Route::post('acceso', 'Auth\LoginController@loginsample')->name('acceso');

Route::post('/entrar', 'AuthenticareSample@login')->name('entrar');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/admin', 'AdminController@admin')->name('admin');

Route::get('/redirect', 'SocialAuthFacebookController@redirect');
Route::get('/callback', 'SocialAuthFacebookController@callback');

Route::resource('activity', 'ActivityController');
Route::get('activity_datatable', 'ActivityController@datatable');
Route::get('consulta', 'ActivityController@consulta')->name('consulta');

//Admin CPANEL
Route::resource('Category', 'CategoryController');
Route::get('Category_dt', 'CategoryController@datatable');
Route::get('Category_list', 'CategoryController@list');

Route::resource('Subcategory', 'SubcategoryController');
Route::get('Subcategory_dt', 'SubcategoryController@datatable');
Route::get('Subcategory_list', 'SubcategoryController@list');

Route::resource('Store', 'StoreController');
Route::get('Store_dt', 'StoreController@datatable');
Route::get('Store_list', 'StoreController@list');

Route::resource('Product', 'ProductController');
Route::get('Product_dt', 'ProductController@datatable');
Route::get('Product_list', 'ProductController@list');