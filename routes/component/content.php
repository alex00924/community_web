<?php
$prefixSearch = sc_config('PREFIX_SEARCH')??'search';
$prefixContact = sc_config('PREFIX_CONTACT')??'contact';
$prefixNews = sc_config('PREFIX_NEWS')??'news';
$prefixAboutus = sc_config('PREFIX_ABOUTUS')??'about-us';
Route::get('/'.$prefixSearch.$suffix, 'ShopFront@search')
->name('search');
Route::post('/subscribe', 'ContentFront@emailSubscribe')
->name('subscribe');
Route::get('/'.$prefixContact.$suffix, 'ContentFront@getContact')
->name('contact');
Route::post('/contact', 'ContentFront@postContact')
->name('contact.post');
Route::get('/'.$prefixNews, 'ContentFront@news')
->name('news');
Route::get('/'.$prefixNews.'/category/{alias}'.$suffix, 'ContentFront@newsCategory')
->name('news.category');
Route::get('/'.$prefixNews.'/{alias}'.$suffix, 'ContentFront@newsDetail')
->name('news.detail');
Route::get('/'.$prefixAboutus, 'ContentFront@aboutUs')
->name('aboutus');
Route::get('/'.$prefixAboutus.'/{alias}'.$suffix, 'ContentFront@aboutUsDetail')
->name('aboutus.detail');