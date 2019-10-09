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



Route::get('obats/data', ['uses'=>'ObatsController@data', 'as'=>'obats.data']);
Route::get('hargaobats/data', ['uses'=>'HargaObatController@data', 'as'=>'hargaobats.data']);
Route::get('detracikans/data', ['uses'=>'DetRacikanController@data', 'as'=>'detracikans.data']);
Route::get('stoks/data', ['uses'=>'StokController@data', 'as'=>'stoks.data']);
Route::get('detracikans/{racikan}/racik', ['uses'=>'DetRacikanController@racikan', 'as'=>'detracikans.racikan']);
Route::get('transactions/cari', ['uses'=>'TransactionController@getData', 'as'=>'transactions.cari']);
Route::get('transactions/stok', ['uses'=>'TransactionController@getStok', 'as'=>'transactions.stok']);
// Route::get('obats', ['uses'=>'ObatsController@index', 'as'=>'obats.index']);
Route::resources([
    'obats' =>'ObatsController',
    'hargaobats'=> 'HargaObatController',
    'detracikans'=>'DetRacikanController',
    'stoks'=>'StokController',
    'transactions'=>'TransactionController'
]);