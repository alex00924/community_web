<?php
$router->group(['prefix' => 'questionaire'], function ($router) {
    $router->get('/', 'ShopQuestionaireController@index')->name('admin_questionaire.index');
    $router->get('create', 'ShopQuestionaireController@create')->name('admin_questionaire.create');
    $router->post('/create', 'ShopQuestionaireController@postCreate')->name('admin_questionaire.create');
    $router->get('/edit/{id}', 'ShopQuestionaireController@edit')->name('admin_questionaire.edit');
    $router->post('/edit/{id}', 'ShopQuestionaireController@postEdit')->name('admin_questionaire.edit');
    $router->post('/delete/{id}', 'ShopQuestionaireController@delete')->name('admin_questionaire.delete');
    $router->post('/update', 'ShopQuestionaireController@updateNextQuestion')->name('admin_questionaire.update');
});
