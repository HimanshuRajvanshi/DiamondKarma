<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/view_meta_data','MetaDataController@index');
Route::get('/add_meta_data','MetaDataController@show');
Route::get('/add_meta_data/{id}','MetaDataController@show');
Route::POST('/post_meta','MetaDataController@store');

Route::GET('/post_meta_delete/{id}','MetaDataController@destroy');

//Manage Value Section
Route::get('/view_values/{id}','MetaDataController@viewValues')->name('view_values');
Route::get('/add_meta_value/{mid}','MetaDataController@addMetaValueShow');
Route::get('/edit_meta_value/{id}','MetaDataController@editMetaValue');
Route::Post('/post_value','MetaDataController@postValueSave');
Route::GET('/post_value_delete/{id}','MetaDataController@destroyValue');

//Manage Shop Section.
Route::Get('/list_shop','MetaDataController@listShop');
Route::Get('/add_shop','MetaDataController@addShop');
Route::Get('/add_shop/{id}','MetaDataController@addShop');
Route::Post('/post_shop','MetaDataController@postShop');
Route::Get('/delete_shop/{id}','MetaDataController@deleteshop');

Route::Get('/list_diamond','MetaDataController@listDiamond');
Route::Get('/add_diamond','MetaDataController@addDiamond');
Route::Get('/add_diamond/{id}','MetaDataController@addDiamond');
Route::Post('/post_diamond','MetaDataController@postDiamond');
Route::Get('/delete_diamond/{id}','MetaDataController@deleteDiamond');



