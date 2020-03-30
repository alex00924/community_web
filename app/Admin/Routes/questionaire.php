<?php
$router->group(['prefix' => 'questionaire'], function ($router) {
    $router->get('/', 'ShopQuestionaireController@index')->name('admin_questionaire.index');
    $router->get('/questions/{questionaire_id}', 'ShopQuestionaireController@indexQuestions')->name('admin_questionaire.indexQuestion');
    $router->get('create/{questionaire_id}', 'ShopQuestionaireController@createQuestion')->name('admin_questionaire.createQuestion');
    $router->post('/create/{questionaire_id}', 'ShopQuestionaireController@postCreateQuestion')->name('admin_questionaire.createQuestion');
    $router->get('/edit/q/{id}', 'ShopQuestionaireController@editQuestion')->name('admin_questionaire.editQuestion');
    $router->post('/edit/q/{id}', 'ShopQuestionaireController@postEditQuestion')->name('admin_questionaire.editQuestion');
    $router->post('/delete/q/{id}', 'ShopQuestionaireController@deleteQuestion')->name('admin_questionaire.deleteQuestion');
    $router->post('/update_next_question', 'ShopQuestionaireController@updateNextQuestion')->name('admin_questionaire.updateNextQuestion');
});
