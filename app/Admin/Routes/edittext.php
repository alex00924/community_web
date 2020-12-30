<?php
$router->group(['prefix' => 'edittext'], function ($router) {
  $router->get('/', 'EditText@index')->name('admin_edittext.index');
});