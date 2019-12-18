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

Route::group(['middleware' => ['cors']], function () {
    Route::get('players', 'PlayerController@index')->name('api/players');
    Route::get('players/total', 'PlayerController@total')->name('api/players/total');
    Route::get('players/active', 'PlayerController@active')->name('api/players/active');
    Route::get('tran_players', 'TranPlayerController@index')->name('api/tran_players');
    Route::get('transactions/game', 'TransactionController@game')->name('api/transactions/game');
    Route::get('transactions/game/played', 'TransactionController@gamePlayed')->name('api/transactions/game/played');
    Route::get('transactions/transfer', 'TransactionController@transfer')->name('api/transactions/transfer');

    Route::post('liaison/register', 'LiaisonAgentController@register');
    Route::post('liaison/register/{parent}', 'LiaisonAgentController@registerChild');
    Route::post('liaison/login', 'LiaisonAgentController@login');
    Route::get('liaison/list', 'LiaisonAgentController@list');
});
