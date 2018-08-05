<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'admin'], function () {
    Route::get('/ajaxGetBlogData', 'AdminBlogController@ajaxGetBlogData')->name('blog-data-api');
    Route::get('/ajaxGetUserData', 'AdminUserController@ajaxGetUserData')->name('user-data-api');
    Route::get('/ajaxGetRecipeData', 'AdminRecipeController@ajaxGetRecipeData')->name('recipe-data-api');
    Route::get('/ajaxGetIngredientSectionData', 'AdminRecipeIngredientSectionController@ajaxGetIngredientSectionData')->name('recipe-ingredient-section-data-api');
    Route::get('/ajaxGetIngredientData', 'AdminIngredientController@ajaxGetIngredientData')->name('ingredient-data-api');
    Route::get('/ajaxGetIngredientTypeData', 'AdminIngredientTypeController@ajaxGetIngredientTypeData')->name('ingredient-type-data-api');
    Route::get('/ajaxGetEdmData', 'AdminRegularEDMController@ajaxGetEdmData')->name('edm-data-api');
    Route::get('/ajaxGetNewsletterData', 'AdminNewsletterController@ajaxGetNewsletterData')->name('newsletter-data-api');

    Route::get('/ajaxGetBlogImageData/{type?}', 'AdminImageController@ajaxGetImageData')->name('image-data-api');

});