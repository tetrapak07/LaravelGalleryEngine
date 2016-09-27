<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('/category/{categoty_slug}', 'CategoryController@categoryList');

Route::get('/albom/{albom_slug}', 'AlbomController@albomPhotosList');

Route::get('/albom/{albom_slug}/all', 'AlbomController@all');

Route::get('/image/{image_slug}', 'ImageController@oneImage');

Route::get('search/{query}/{page?}', 'SearchController@show');
Route::get('search', 'SearchController@index');

//Route::get('home', 'HomeController@index');

Route::post('/admin/password', 'AdminController@changePassword');

Route::get('/admin/sitemap', 'AdminController@sitemapGen');

Route::get('admin/settings/all', 'AdminSettingController@all');
Route::resource('admin/settings', 'AdminSettingController');
Route::get('admin/settings/del/{id}', 'AdminSettingController@del');

Route::get('admin/categories/all', 'AdminCategoryController@all');
Route::resource('admin/categories', 'AdminCategoryController');
Route::get('admin/categories/del/{id}', 'AdminCategoryController@del');
Route::post('admin/categories/on_off', 'AdminCategoryController@onOff');
Route::post('admin/categories/del_many', 'AdminCategoryController@delMany');

Route::get('admin/alboms/all', 'AdminAlbomController@all');
Route::post('admin/alboms/change_visible_many', 'AdminAlbomController@changeVisibleMany');
Route::post('admin/alboms/del_cat', 'AdminAlbomController@delCat');
Route::post('admin/alboms/add_cat', 'AdminAlbomController@addCat');
Route::match(array('GET', 'POST'),'admin/alboms/filter', ['as' => 'albomFilter', 'uses' => 'AdminAlbomController@filter']);
Route::resource('admin/alboms', 'AdminAlbomController');
Route::get('admin/alboms/del/{id}', 'AdminAlbomController@del');
Route::post('admin/alboms/del_many', 'AdminAlbomController@delMany');

Route::get('admin/images/all', 'AdminImageController@all');
Route::post('admin/images/change_visible_many', 'AdminImageController@changeVisibleMany');
Route::match(array('GET', 'POST'),'admin/images/filter', ['as' => 'imageFilter', 'uses' => 'AdminImageController@filter']);
Route::resource('admin/images', 'AdminImageController');
Route::get('admin/images/del/{id}', 'AdminImageController@del');
Route::post('admin/images/del_many', 'AdminImageController@delMany');
Route::post('admin/images/change_image_albom', 'AdminImageController@changeImageAlbom');

Route::get('admin/pages/all', 'AdminPageController@all');
Route::post('admin/pages/change_visible_many', 'AdminPageController@changeVisibleMany');
Route::post('admin/pages/filter', 'AdminPageController@filter');
Route::resource('admin/pages', 'AdminPageController');
Route::get('admin/pages/del/{id}', 'AdminPageController@del');
Route::post('admin/pages/del_many', 'AdminPageController@delMany');
Route::post('admin/pages/change_page_cat', 'AdminPageController@changePageCategory');

Route::resource('admin/vk_parser', 'AdminVkParserController');

Route::resource('admin/meta_auto', 'AdminMetaAutoController');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
