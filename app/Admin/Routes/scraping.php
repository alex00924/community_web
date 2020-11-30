<?php
$router->group(['prefix' => 'scraping'], function ($router) {
    $router->get('/', 'ScrapingController@index')->name('admin_scraping.index');
    $router->post('/email-extractor', 'ScrapingController@email_extractor')->name('admin_scraping.email_extractor');
    $router->post('/', 'ScrapingController@web_scraping')->name('admin_scraping.web_scraping');
    $router->post('/crunchbase-scraping', 'ScrapingController@crunchbase_scraping')->name('admin_scraping.crunchbase_scraping');
    $router->post('/linkedin-scraping', 'ScrapingController@linkedin_scraping')->name('admin_scraping.linkedin_scraping');
});
