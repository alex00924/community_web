<?php
$router->group(['prefix' => 'scraping/mr_admin/'], function ($router) {
    $router->get('/', 'ScrapingController@mr_Admin')->name('admin_scraping.mr_admin');
    $router->post('/email-extractor', 'ScrapingController@email_extractor')->name('admin_scraping.email_extractor');
    $router->post('/linkedin-scraping', 'ScrapingController@linkedin_scraping')->name('admin_scraping.linkedin_scraping');
    $router->get('/add-image', 'ScrapingController@createImage')->name('admin_scraping.add_image');
    $router->post('/add-image', 'ScrapingController@postcreateImage')->name('admin_scraping.add_image');
    $router->get('/search-image', 'ScrapingController@search_image')->name('admin_scraping.search_image');
});