<?php
$router->group(['prefix' => 'questionaire'], function ($router) {
    $router->get('/', 'ShopQuestionaireController@index')->name('admin_questionaire.index');
    $router->get('create', 'ShopQuestionaireController@create')->name('admin_questionaire.create');
    $router->post('/create', 'ShopQuestionaireController@postCreate')->name('admin_questionaire.create');
    $router->get('/edit/{id}', 'ShopQuestionaireController@edit')->name('admin_questionaire.edit');
    $router->post('/edit/{id}', 'ShopQuestionaireController@postEdit')->name('admin_questionaire.edit');
    $router->post('/delete/{id}', 'ShopQuestionaireController@delete')->name('admin_questionaire.delete');

    $router->get('/questions/{questionaire_id}', 'ShopQuestionaireController@indexQuestions')->name('admin_questionaire.indexQuestion');
    $router->get('create/{questionaire_id}', 'ShopQuestionaireController@createQuestion')->name('admin_questionaire.createQuestion');
    $router->post('/create/{questionaire_id}', 'ShopQuestionaireController@postCreateQuestion')->name('admin_questionaire.createQuestion');
    $router->get('/edit/q/{questionaire_id}/{id}', 'ShopQuestionaireController@editQuestion')->name('admin_questionaire.editQuestion');
    $router->post('/edit/q/{questionaire_id}/{id}', 'ShopQuestionaireController@postEditQuestion')->name('admin_questionaire.editQuestion');
    $router->post('/delete/q/{id}', 'ShopQuestionaireController@deleteQuestion')->name('admin_questionaire.deleteQuestion');
    $router->post('/update_next_question', 'ShopQuestionaireController@updateNextQuestion')->name('admin_questionaire.updateNextQuestion');
});
