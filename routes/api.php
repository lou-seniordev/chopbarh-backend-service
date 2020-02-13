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

        Route::post('/transfer/agent', 'TransactionController@transfer_agent')->name('api/transactions/transfer/agent');
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
        Route::post('/', 'DepositController@add')->name('api/deposits/add');
        Route::get('/{playerId}', 'DepositController@get')->name('api/deposits/get');
        Route::post('/search', 'DepositController@search')->name('api/deposits/search');
        Route::put('/', 'DepositController@update')->name('api/deposits/update');
        Route::patch('/', 'DepositController@update')->name('api/deposits/update');
        Route::delete('/', 'DepositController@delete')->name('api/deposits/delete');

        Route::post('/deposit', [
            'middleware' => 'check_hash_mac',
            'uses' => 'DepositController@deposit'
        ])->name('api/deposits/deposit');
    });

    Route::group([
        'prefix' => 'withdrawals'
    ], function() {
        Route::post('/', 'WithdrawalController@add')->name('api/withdrawals/add');
        Route::get('/{playerId}', 'WithdrawalController@get')->name('api/withdrawals/get');
        Route::post('/search', 'WithdrawalController@search')->name('api/withdrawals/search');
        Route::put('/', 'WithdrawalController@update')->name('api/withdrawals/update');
        Route::patch('/', 'WithdrawalController@update')->name('api/withdrawals/update');
        Route::delete('/', 'WithdrawalController@delete')->name('api/withdrawals/delete');

        Route::post('/withdraw', [
            'middleware' => 'check_hash_mac',
            'uses' => 'WithdrawalController@withdraw'
        ])->name('api/withdrawals/withdraw');
    });

    Route::group([
        'prefix' => 'refunds'
    ], function() {
        Route::post('/', 'RefundController@add')->name('api/refunds/add');
        Route::get('/{playerId}', 'RefundController@get')->name('api/refunds/get');

        Route::post('/dispute', 'RefundController@dispute')->name('api/refunds/dispute');
    });

    Route::group([
        'prefix' => 'cards'
    ], function() {
        Route::post('/paystack', 'PaystackController@add_card')->name('api/cards/paystack/add');
        Route::get('/paystack/{playerId}', 'PaystackController@list_card')->name('api/cards/paystack/list');

        Route::post('/rave', 'RaveController@add_card')->name('api/cards/rave/add');
        Route::get('/rave/{playerId}', 'RaveController@list_card')->name('api/cards/rave/list');
    });

    Route::group([
        'prefix' => 'banks'
    ], function() {
        Route::post('/paystack', 'PaystackController@add_bank')->name('api/banks/paystack/add');
        Route::get('/paystack/{playerId}', 'PaystackController@list_bank')->name('api/banks/paystack/list');
    });

    Route::group([
        'prefix' => 'accounts'
    ], function() {
        Route::post('/blacklist', 'AccountController@add_blacklist')->name('api/accounts/blacklist/add');
        Route::get('/blacklist', 'AccountController@list_blacklist')->name('api/accounts/blacklist/list');

        Route::post('/super_agent', 'AccountController@add_super_agent')->name('api/accounts/super_agent/add');

        Route::post('/payment', 'AccountController@add_payment')->name('api/accounts/payment/add');
        Route::get('/payment/{playerId}', 'AccountController@list_payment')->name('api/accounts/payment/list');

        Route::post('/withdrawal', 'AccountController@add_withdrawal')->name('api/accounts/withdrawal/add');
        Route::get('/withdrawal/{playerId}', 'AccountController@list_withdrawal')->name('api/accounts/withdrawal/list');
    });
});
