<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('players', 'PlayerController@index')->name('api/players');
Route::get('tran_players', 'TranPlayerController@index')->name('api/tran_players');
Route::get('transactions/game', 'TransactionController@game')->name('api/transactions/game');
Route::get('transactions/transfer', 'TransactionController@transfer')->name('api/transactions/transfer');
