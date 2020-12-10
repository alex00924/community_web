<?php
$prefixMarketing = 'marketing';

Route::group(['prefix' => $prefixMarketing], function ($router) {
    $router->get('/', 'MarketingController@index')->name('marketing');
    $router->post('/sendemail', 'MarketingController@sendEmail')->name('marketing.sendemail');
    $router->get('/research', 'MarketingController@research')->name('marketing.research');
    // $router->post('/addAnswer', 'QuestionaireController@addAnswer')->name('marketing.add_answer');
});