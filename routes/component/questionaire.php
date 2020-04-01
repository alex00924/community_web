<?php
$prefixQuestionaire = 'questionaire';

Route::group(['prefix' => $prefixQuestionaire, 'middleware' => 'auth'], function ($router) {
    $router->post('/addAnswer', 'QuestionaireController@addAnswer')->name('questionaire.add_answer');
});