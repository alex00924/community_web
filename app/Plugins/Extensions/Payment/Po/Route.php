<?php

Route::group(
    [
        'prefix'    => 'extension/payment',
        'namespace' => 'App\Plugins\Extensions\Payment\Po\Controllers',
    ], function () {
        Route::get('po/complete', 'PoController@complete')
            ->name('po.complete');
        Route::get('po/cancel', 'PoController@cancel')
            ->name('po.cancel');
    });
