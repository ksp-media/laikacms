<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Route::group(['prefix' => _LCMS_PREFIX_], function() {
    Route::get('/', '\KSPM\LCMS\Controllers\MainController@showIndex');
    Route::get('logout', '\KSPM\LCMS\Controllers\MainController@logoutAction');
    Route::get('user', '\KSPM\LCMS\Controllers\UserController@showIndex');
    Route::get('user/form/{id}', '\KSPM\LCMS\Controllers\UserController@showForm');
    Route::post('user/form', '\KSPM\LCMS\Controllers\UserController@saveForm');
    Route::get('cms/page/create', '\KSPM\LCMS\Controllers\CmsController@showCreatePageForm');
    Route::get('cms/page/{id}/edit', '\KSPM\LCMS\Controllers\CmsController@showEditPageForm');
	Route::get('cms/page/{id}/delete', '\KSPM\LCMS\Controllers\CmsController@deletePageAction');
    Route::post('cms/page/save', '\KSPM\LCMS\Controllers\CmsController@savePageAction');
    Route::get('cms/content', '\KSPM\LCMS\Controllers\CmsController@listAction');
    Route::get('cms/clearcache', array('as' => 'ajax', 'uses' => '\KSPM\LCMS\Controllers\CmsController@clearCacheAction'));
    Route::get('cms/pages', '\KSPM\LCMS\Controllers\CmsController@listPagesShow');
    Route::get('login', '\KSPM\LCMS\Controllers\MainController@showLogin');
    Route::post('login', '\KSPM\LCMS\Controllers\MainController@loginAction');
    Route::post('cms/content/create', '\KSPM\LCMS\Controllers\CmsController@createAction');
    Route::get('assets', '\KSPM\LCMS\Controllers\AssetController@showIndex');
    Route::get('assets/folder/{folder}', '\KSPM\LCMS\Controllers\AssetController@showIndex');
    Route::get('assets/folder/{folder}/create', '\KSPM\LCMS\Controllers\AssetController@createFolderAction');
    Route::get('assets/{id}/delete', '\KSPM\LCMS\Controllers\AssetController@assetDeleteAction');
    Route::post('assets/folder/update', '\KSPM\LCMS\Controllers\AssetController@updateFolderAttributeAction');
    Route::post('assets/upload/{folder}', '\KSPM\LCMS\Controllers\AssetController@uploadAction');
    Route::get('assets/manager', '\KSPM\LCMS\Controllers\AssetController@showAssetManager');
    Route::post('cms/page/updatetree', '\KSPM\LCMS\Controllers\CmsController@updateTreeAction');
});


