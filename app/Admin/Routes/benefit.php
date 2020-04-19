<?php
$router->group(['prefix' => 'benefit'], function ($router) {
    $router->get('/', 'ShopBenefitController@index')->name('admin_benefit.index');
    $router->get('create', 'ShopBenefitController@create')->name('admin_benefit.create');
    $router->post('/create', 'ShopBenefitController@postCreate')->name('admin_benefit.create');
    $router->get('/edit/{id}', 'ShopBenefitController@edit')->name('admin_benefit.edit');
    $router->post('/edit/{id}', 'ShopBenefitController@postEdit')->name('admin_benefit.edit');
    $router->post('/delete', 'ShopBenefitController@deleteList')->name('admin_benefit.delete');
});
