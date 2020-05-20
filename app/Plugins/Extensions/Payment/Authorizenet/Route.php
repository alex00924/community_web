<?php

Route::group(
    [
        'prefix'    => 'extension/payment',
        'namespace' => 'App\Plugins\Extensions\Payment\Authorizenet\Controllers',
    ], function () {
        Route::get('authorizenet/complete', 'AuthorizenetController@complete')
            ->name('authorizenet.complete');
        Route::get('authorizenet/cancel', 'AuthorizenetController@cancel')
            ->name('authorizenet.cancel');
        Route::post('authorizenet/process/payment', 'AuthorizenetController@processPayment')
            ->name('authorizenet.process_payment');
    });
