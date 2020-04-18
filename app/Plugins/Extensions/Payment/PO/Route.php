<?php

Route::group(
    [
        'prefix'    => 'extension/payment',
        'namespace' => 'App\Plugins\Extensions\Payment\PO\Controllers',
    ], function () {
        Route::get('po/complete', 'POController@complete')
            ->name('po.complete');
        Route::get('po/cancel', 'POController@cancel')
            ->name('po.cancel');
    });
