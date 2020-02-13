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

Route::post('/vc_consulta', 'LoginUserController@login')->name('vc_consulta');
Route::get('consulta', 'ActivityController@consulta')->name('consulta')->middleware('auth');


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/admin', 'AdminController@admin')->name('admin');

Route::get('/redirect', 'SocialAuthFacebookController@redirect');
Route::get('/callback', 'SocialAuthFacebookController@callback');

Route::resource('Activity', 'ActivityController')->middleware('auth');
Route::get('Activity_dt', 'ActivityController@datatable')->middleware('auth');


//Admin CPANEL
Route::resource('Category', 'CategoryController')->middleware('auth');
Route::get('Category_dt', 'CategoryController@datatable')->middleware('auth');
Route::get('Category_list', 'CategoryController@list')->middleware('auth');

Route::resource('Subcategory', 'SubcategoryController')->middleware('auth');
Route::get('Subcategory_dt', 'SubcategoryController@datatable')->middleware('auth');
Route::get('Subcategory_list', 'SubcategoryController@list')->middleware('auth');

Route::resource('Store', 'StoreController')->middleware('auth');
Route::get('Store_dt', 'StoreController@datatable')->middleware('auth');
Route::get('Store_list', 'StoreController@list')->middleware('auth');

Route::resource('Product', 'ProductController')->middleware('auth');
Route::get('Product_dt', 'ProductController@datatable')->middleware('auth');
Route::get('Product_list', 'ProductController@list')->middleware('auth');


Route::get('reportclientuser','ReportController@reportClientUse')->name('reportclientuser')->middleware('auth');
Route::get('reportclienreading','ReportController@reportClientReading')->name('reportclienreading')->middleware('auth');
Route::get('listsucursal', 'StoreController@list')->name('listsucursal')->middleware('auth');