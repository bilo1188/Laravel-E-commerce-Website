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

//Route::get('/', function () {
  //  return view('welcome');
//});
//Route::get('/single', 'Jacket@instance');

 Route::match(['get','post'],'/','IndexController@index');
 Route::get('/products/{id}','ProductController@products');
 Route::get('/categories/{categories_id}','indexController@categories');
 Route::match(['get','post'],'/admin','AdminController@login');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['middleware'=>['auth']],function(){

  
  Route::match(['get','post'],'/admin/dashboard','AdminController@dashboard');

  //category route
  Route::match(['get','post'],'/admin/add-category','CategoryController@addCategory');
  Route::match(['get','post'],'/admin/view-categories','CategoryController@viewCategories');
  Route::match(['get','post'],'/admin/edit-category/{id}','CategoryController@editCategory');
  Route::match(['get','post'],'/admin/delete-category/{id}','CategoryController@deleteCategory');

  //product route
  Route::match(['get','post'],'/admin/add-product','ProductController@addProducts');
  Route::match(['get','post'],'/admin/view-products','ProductController@viewProducts');
  Route::match(['get','post'],'/admin/edit-product/{id}','ProductController@editProduct');
  Route::match(['get','post'],'/admin/delete-product/{id}','ProductController@deleteProduct');
  Route::match(['get','post'],'/admin/add-images/{id}','ProductController@addImages');
  Route::match(['get','post'],'/admin/add-images/{id}','ProductController@addImages');
  //

  //product attributes
  Route::match(['get','post'],'/admin/add-attributes/{id}','ProductController@addAttributes');
  Route::match(['get','post'],'/admin/delete-attributes/{id}','ProductController@deleteAttributes');
  Route::match(['get','post'],'/admin/delete-alt-image/{id}','ProductController@deleteAltImage');

});

Route::get('/logout','AdminController@logout');