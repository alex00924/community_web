<?php

Route::group(
    [
        'prefix'    => 'extension/payment',
        'namespace' => 'App\Plugins\Extensions\Payment\Card\Controllers',
    ], function () {
        Route::get('card/complete', 'CardController@complete')
            ->name('card.complete');
        Route::get('card/cancel', 'CardController@cancel')
            ->name('card.cancel');
    });
