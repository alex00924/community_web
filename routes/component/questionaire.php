<?php
$prefixQuestionaire = 'questionaire';

Route::group(['prefix' => $prefixQuestionaire, 'middleware' => 'auth'], function ($router) {
    $router->get('/', 'QuestionaireController@index')->name('questionaire.index');
    $router->get('/detail/{questionaire_id}', 'QuestionaireController@detail')->name('questionaire.detail');
    $router->post('/addAnswer', 'QuestionaireController@addAnswer')->name('questionaire.add_answer');
});