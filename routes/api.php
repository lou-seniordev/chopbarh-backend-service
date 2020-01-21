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

Route::group(['middleware' => ['cors', 'check_api_key']], function () {
    Route::group([
        'prefix' => 'player'
    ], function() {
        Route::post('/login', 'PlayerController@login')->name('api/player/login');
        Route::post('/get', 'PlayerController@get')->name('api/player/get');
        Route::post('/edit', 'PlayerController@edit')->name('api/player/edit');
        Route::post('/change/pin', 'PlayerController@change_pin')->name('api/player/change/pin');
        Route::post('/update/coin', 'PlayerController@update_coin')->name('api/player/update/coin');
        Route::post('/update/cash', 'PlayerController@update_cash')->name('api/player/update/cash');
    });

    Route::group([
        'prefix' => 'players'
    ], function() {
        Route::get('/', 'PlayerController@index')->name('api/players');
        Route::get('/total', 'PlayerController@total')->name('api/players/total');
        Route::get('/active', 'PlayerController@active')->name('api/players/active');
    });

    Route::group([
        'prefix' => 'transactions'
    ], function() {
        Route::get('/game', 'TransactionController@game')->name('api/transactions/game');
        Route::get('/game/played', 'TransactionController@gamePlayed')->name('api/transactions/game/played');
        Route::get('/transfer', 'TransactionController@transfer')->name('api/transactions/transfer');
    });

    Route::group([
        'prefix' => 'tran_players'
    ], function() {
        Route::get('/', 'TranPlayerController@index')->name('api/tran_players');
    });

    Route::group([
        'prefix' => 'liaison'
    ], function() {
        Route::post('/register', 'LiaisonAgentController@register');
        Route::post('/register/{parent}', 'LiaisonAgentController@registerChild');
        Route::post('/login', 'LiaisonAgentController@login');
        Route::post('/list', 'LiaisonAgentController@list');
    });

    Route::group([
        'prefix' => 'deposits'
    ], function() {
        Route::post('/add', 'DepositController@add')->name('api/deposits/add');
    });

    Route::group([
        'prefix' => 'withdrawals'
    ], function() {
        Route::post('/add', 'WithdrawalController@add')->name('api/withdrawals/add');
    });

    Route::group([
        'prefix' => 'refunds'
    ], function() {
        Route::post('/add', 'RefundController@add')->name('api/refunds/add');
    });

    Route::group([
        'prefix' => 'cards'
    ], function() {
        Route::post('/paystack/add', 'PaystackController@add_card')->name('api/cards/paystack/add');
        Route::post('/rave/add', 'RaveController@add_card')->name('api/cards/rave/add');
    });

    Route::group([
        'prefix' => 'banks'
    ], function() {
        Route::post('/paystack/add', 'PaystackController@add_bank')->name('api/banks/paystack/add');
    });

    Route::group([
        'prefix' => 'accounts'
    ], function() {
        Route::post('/payment/add', 'AccountController@add_payment')->name('api/accounts/payment/add');
        Route::post('/withdrawal/add', 'AccountController@add_withdrawal')->name('api/accounts/withdrawal/add');
    });
});
