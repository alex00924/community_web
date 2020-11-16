<?php
$router->group(['prefix' => 'scraping'], function ($router) {
    $router->get('/', 'ScrapingController@index')->name('admin_scraping.index');
    $router->post('/email-extractor', 'ScrapingController@email_extractor')->name('admin_scraping.email_extractor');
    $router->post('/web-scraping', 'ScrapingController@web_scraping')->name('admin_scraping.web_scraping');
});
