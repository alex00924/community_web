<?php
$prefixQuestionaire = 'questionaire';

Route::group(['prefix' => $prefixQuestionaire, 'middleware' => 'auth'], function ($router) {
    $router->get('/', 'QuestionaireController@index')->name('questionaire.index');
    $router->post('/addAnswer', 'QuestionaireController@addAnswer')->name('questionaire.add_answer');
});