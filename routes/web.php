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

Route::group([
    'prefix' => 'players'
], function () {
    Route::get('/', 'PlayerController@index')->name('players');
    Route::get('/list', 'PlayerController@list')->name('players/list');
    Route::get('/fetchFromGameSpark', 'PlayerController@fetchFromGameSpark')->name('players/fetchFromGameSpark');
});

Route::group([
    'prefix' => 'tran_players'
], function () {
    Route::get('/fetchFromGameSpark', 'TranPlayerController@fetchFromGameSpark')->name('tran_players/fetchFromGameSpark');
});

Route::group([
    'prefix' => 'transactions'
], function () {
    Route::get('/fetchFromGameSpark', 'TransactionController@fetchFromGameSpark')->name('transactions/fetchFromGameSpark');
});


Route::get('api/deposits/get', 'DepositController@index');
Route::get('api/deposits/search', 'DepositController@search');
Route::post('api/deposits/add', 'DepositController@store');
Route::put('api/deposits/update/{id}', 'DepositController@update');

Route::get('api/refunds/get', 'RefundController@index');
Route::get('api/refunds/search', 'RefundController@search');
Route::post('api/refunds/add', 'RefundController@store');
Route::get('api/withdrawals/get', 'WithdrawalController@index');
Route::get('api/withdrawals/search', 'WithdrawalController@search');
Route::post('api/withdrawals/add', 'WithdrawalController@store');
