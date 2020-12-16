<?php
$router->group(['prefix' => 'db_customer'], function ($router) {
  $router->get('/individual', 'DBCustomerController@index')->name('admin_dbcumstomer.individual.index');
  $router->get('/individual/create', 'DBCustomerController@createIndividual')->name('admin_dbcumstomer.individual.create');
  $router->post('/individual/create', 'DBCustomerController@postCreateIndividual')->name('admin_dbcumstomer.individual.create');
  $router->get('/individual/edit/{id}', 'DBCustomerController@editIndividual')->name('admin_dbcumstomer.individual.edit');
  $router->post('/individual/edit/{id}', 'DBCustomerController@editPostIndividual')->name('admin_dbcumstomer.individual.edit');
  $router->post('/individual/delete', 'DBCustomerController@deleteIndividual')->name('admin_dbcumstomer.individual.delete');
  $router->post('/individual/import', 'DBCustomerController@importIndividual')->name('admin_dbcumstomer.individual.import');
  $router->get('/individual/export', 'DBCustomerController@exportIndividual')->name('admin_dbcumstomer.individual.export');
  
  $router->get('/company', 'DBCustomerController@companyindex')->name('admin_dbcumstomer.company.index');
  $router->get('/company/create', 'DBCustomerController@createCompany')->name('admin_dbcumstomer.company.create');
  $router->post('/company/create', 'DBCustomerController@postCreateCompany')->name('admin_dbcumstomer.company.create');
  $router->get('/company/edit/{id}', 'DBCustomerController@editCompany')->name('admin_dbcumstomer.company.edit');
  $router->post('/company/edit/{id}', 'DBCustomerController@editPostCompany')->name('admin_dbcumstomer.company.edit');
  $router->post('/company/delete', 'DBCustomerController@deleteCompany')->name('admin_dbcumstomer.company.delete');
  $router->post('/company/import', 'DBCustomerController@importCompany')->name('admin_dbcumstomer.company.import');
  $router->get('/company/export', 'DBCustomerController@exportCompany')->name('admin_dbcumstomer.company.export');
});