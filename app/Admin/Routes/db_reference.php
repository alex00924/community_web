<?php
$router->group(['prefix' => 'db_reference'], function ($router) {
  $router->get('/', 'DBReferenceController@index')->name('admin_dbreference.index');
});