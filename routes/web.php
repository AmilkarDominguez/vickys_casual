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


//Lists
Route::get('listsucursal', 'StoreController@list')->name('listsucursal')->middleware('auth');
Route::get('listsubcategoria', 'SubcategoryController@list')->name('listsubcategoria')->middleware('auth');


//Reports Views
// 1.- sacara por rango de fecha y sucursal la cantidad de usuario que se registran a la aplicacion
Route::get('client_store','ReportController@client_store')->name('client_store')->middleware('auth');
Route::get('clientstore','ReportController@clientstore')->name('clientstore')->middleware('auth');
// 2.- Sacar por rango de fecha y sucursal  cuantas veces usa un cliente
Route::get('count_client_store','ReportController@count_client_store')->name('count_client_store')->middleware('auth');
Route::get('countclientstore','ReportController@countclientstore')->name('countclientstore')->middleware('auth');
// 3.- sacar por rango de fecha y sucursal cantidad de lecturas de un item
Route::get('count_activity_item','ReportController@count_activity_item')->name('count_activity_item')->middleware('auth');
Route::get('countactivityitem','ReportController@countactivityitem')->name('countactivityitem')->middleware('auth');
// 4.- Sacar por rango de fecha y sucursal cantidad de lecturado por sub-grupo
Route::get('activity_subgroup','ReportController@activity_subgroup')->name('activity_subgroup')->middleware('auth');
Route::get('activitysubgroup','ReportController@activitysubgroup')->name('activitysubgroup')->middleware('auth');



