<?php
$prefixQuestionaire = 'questionaire';

Route::group(['prefix' => $prefixQuestionaire], function ($router) {
    $router->get('/', 'QuestionaireController@index')->name('questionaire.index');
    $router->get('/detail/{questionaire_id}', 'QuestionaireController@detail')->name('questionaire.detail');
    $router->get('/detail/corona/{questionaire_id}', 'QuestionaireController@detail')->name('questionaire.detail.corona');
    $router->post('/addAnswer', 'QuestionaireController@addAnswer')->name('questionaire.add_answer');
});