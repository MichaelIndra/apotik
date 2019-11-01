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


Route::get('admin', ['uses'=>'AdminController@index']);

Route::get('obats/data', ['uses'=>'ObatsController@data', 'as'=>'obats.data']);
Route::get('hargaobats/data', ['uses'=>'HargaObatController@data', 'as'=>'hargaobats.data']);
Route::get('detracikans/data', ['uses'=>'DetRacikanController@data', 'as'=>'detracikans.data']);
Route::get('stoks/data', ['uses'=>'StokController@data', 'as'=>'stoks.data']);
Route::get('detracikans/{racikan}/racik', ['uses'=>'DetRacikanController@racikan', 'as'=>'detracikans.racikan']);

Route::group(['prefix'=>'transactions'], function(){
    Route::get('/cari', ['uses'=>'TransactionController@getData', 'as'=>'transactions.cari']);
    Route::get('/stok', ['uses'=>'TransactionController@getStok', 'as'=>'transactions.stok']);
    Route::get('/addcart', ['uses'=>'TransactionController@cart_add', 'as'=>'transactions.cartadd']);
    Route::get('/addtransaksi', ['uses'=>'TransactionController@addtransaksi', 'as'=>'transactions.addtransaksi']);
    Route::get('/delall', ['uses'=>'TransactionController@destroy', 'as'=>'transactions.destroy']);
    Route::get('/{noinvoice}/{bayar}/printinvoice', ['uses'=>'TransactionController@cetakinvoice', 'as'=>'transactions.cetak']);

});


// Route::get('obats', ['uses'=>'ObatsController@index', 'as'=>'obats.index']);
Route::resources([
    'obats' =>'ObatsController',
    'hargaobats'=> 'HargaObatController',
    'detracikans'=>'DetRacikanController',
    'stoks'=>'StokController',
    'transactions'=>'TransactionController'
]);

Route::get('hellopdf', function(){
    return PDF::loadHTML('Hello World!')->stream('download.pdf');
});