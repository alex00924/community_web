<?php
$router->group(['prefix' => 'scraping/bd_admin'], function ($router) {
    $router->get('/', 'ScrapingController@index')->name('admin_scraping.index');
    $router->post('/email-generator', 'ScrapingController@email_generator')->name('admin_scraping.email-generator');
    $router->post('/web-scraping', 'ScrapingController@web_scraping')->name('admin_scraping.web_scraping');
});
