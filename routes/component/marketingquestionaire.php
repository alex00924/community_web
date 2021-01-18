<?php
$prefixMarketing = 'marketingquestionaire';

Route::group(['prefix' => $prefixMarketing], function ($router) {
    $router->get('/detail/{questionaire_id}/{method?}', 'MarketingQuestionaireController@detail')->name('marketquestionaire.detail');
    $router->get('/detail/corona/{questionaire_id}', 'MarketingQuestionaireController@detail')->name('marketquestionaire.detail.corona');
    $router->post('/addAnswer', 'MarketingQuestionaireController@addAnswer')->name('marketquestionaire.add_answer');
    $router->get('/{id}', 'MarketingQuestionaireController@questionaire')->name('marketquestionaire.questionaire');
});