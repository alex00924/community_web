<?php
$router->group(['prefix' => 'db_investor'], function ($router) {
  $router->get('/individual', 'ShopCategoryController@index')->name('admin_category.index');
  $router->get('/company', 'ShopCategoryController@index')->name('admin_category.index');
});