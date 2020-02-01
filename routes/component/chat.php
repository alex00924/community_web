<?php
    $router->group(['prefix' => 'chatkit'], function ($router) {
        Route::get('/', 'ChatController@all');
    });
    
