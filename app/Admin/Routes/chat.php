<?php
$router->group(['prefix' => 'live_chat'], function ($router) {
    $router->get('/', 'ChatkitController@chat')->name('admin_chat');
});