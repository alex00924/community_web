<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

/*
 Home
*/
Route::get('/', 'ShopFront@index')->name('home');
Route::get('index.html', 'ShopFront@index');
Route::get('/network', 'ShopFront@network');
Route::get('/news-covid', 'ShopFront@covidNews');
Route::get('/terms-condition', 'ShopFront@termsCondition');

$suffix = sc_config('SUFFIX_URL')??'';

// Route::get('/network/ambassadors'.$suffix, 'ShopFront@ambassadors')->name('ambassadors');
Route::get('/network/register.html', 'ShopFront@showNetworkLoginForm')->name('showNetworkRegister');
Route::post('/network/register.html', 'ShopFront@network_register')->name('networkRegister');

Route::get('/dashboard.html', 'ShopFront@dashboard');

/*
 Auth
*/
require_once 'component/auth.php';


/*
 Member
*/
require_once 'component/member.php';

/*
 Cart
*/
require_once 'component/cart.php';

/*
 Category
*/
require_once 'component/category.php';

/*
 Brand
*/
require_once 'component/brand.php';

/*
 Vendor
*/
require_once 'component/vendor.php';

/*
 Product
*/
require_once 'component/product.php';

/*
 Content
*/
require_once 'component/content.php';

/*
 Questionaire
*/
require_once 'component/questionaire.php';
require_once 'component/marketing.php';
require_once 'component/marketingquestionaire.php';
/*
 Content
*/
require_once 'component/chat.php';

//Language
Route::get('locale/{code}', function ($code) {
    session(['locale' => $code]);
    return back();
})->name('locale');

//Currency
Route::get('currency/{code}', function ($code) {
    session(['currency' => $code]);
    return back();
});

//Process click banner
Route::get('/banner/{id}', 'ShopFront@clickBanner')
->name('banner.click');    


//--Please keep 2 lines route (pages + pageNotFound) at the bottom
Route::get('/network/{alias}'.$suffix, 'ContentFront@pages')->name('pages');
Route::get('/{alias}'.$suffix, 'ContentFront@pages')->name('pages');
// Route::fallback('ShopFront@pageNotFound')->name('pageNotFound'); //Make sure before using this route. There will be disadvantages when detecting 404 errors for static files like images, scripts ..
//--end keep

//landing page
Route::get('/landing', 'ShopFront@landing'); 

//scraping page
//Route::get('/scraping', 'ShopFront@scraping'); 
//Route::post('/email-extractor', 'ShopFront@email_extractor')->name('email_extractor'); 

//=======End Front

