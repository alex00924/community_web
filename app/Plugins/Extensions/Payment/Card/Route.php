<?php

Route::group(
    [
        'prefix'    => 'extension/payment',
        'namespace' => 'App\Plugins\Extensions\Payment\Card\Controllers',
    ], function () {
        Route::get('card', 'CardController@index')
            ->name('card.index');
        Route::get('card/return/{order_id}', 'CardController@getReturn')
            ->name('card.return');
    });
