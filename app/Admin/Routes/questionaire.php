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

    $router->get('/statistic', 'ShopQuestionaireController@statistic')->name('admin_questionaire.statistic');
    $router->get('/marketing', 'ShopMarketQuestionaireController@index')->name('admin_marketquestionaire.index');
    $router->get('/marketing/create', 'ShopMarketQuestionaireController@create')->name('admin_marketquestionaire.create');
    $router->post('/marketing/create', 'ShopMarketQuestionaireController@postCreate')->name('admin_marketquestionaire.create');
    $router->get('/marketing/edit/{id}', 'ShopMarketQuestionaireController@edit')->name('admin_marketquestionaire.edit');
    $router->post('/marketing/edit/{id}', 'ShopMarketQuestionaireController@postEdit')->name('admin_marketquestionaire.edit');
    $router->post('/marketing/delete/{id}', 'ShopMarketQuestionaireController@delete')->name('admin_marketquestionaire.delete');

    $router->get('/marketing/questions/{questionaire_id}', 'ShopMarketQuestionaireController@indexQuestions')->name('admin_marketquestionaire.indexQuestion');
    $router->get('/marketing/create/{questionaire_id}', 'ShopMarketQuestionaireController@createQuestion')->name('admin_marketquestionaire.createQuestion');
    $router->post('/marketing/create/{questionaire_id}', 'ShopMarketQuestionaireController@postCreateQuestion')->name('admin_marketquestionaire.createQuestion');
    $router->get('/marketing/edit/q/{questionaire_id}/{id}', 'ShopMarketQuestionaireController@editQuestion')->name('admin_marketquestionaire.editQuestion');
    $router->post('/marketing/edit/q/{questionaire_id}/{id}', 'ShopMarketQuestionaireController@postEditQuestion')->name('admin_marketquestionaire.editQuestion');
    $router->post('/marketing/delete/q/{id}', 'ShopMarketQuestionaireController@deleteQuestion')->name('admin_marketquestionaire.deleteQuestion');
    $router->post('/marketing/update_next_question', 'ShopMarketQuestionaireController@updateNextQuestion')->name('admin_marketquestionaire.updateNextQuestion');
    $router->get('/marketing/generateurl', 'ShopMarketQuestionaireController@generateUrl')->name('admin_marketquestionaire.generateurl');
    $router->post('/marketing/generateurl', 'ShopMarketQuestionaireController@updateUrl')->name('admin_marketquestionaire.updateurl');
});
