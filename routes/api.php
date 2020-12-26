<?php

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

Route::middleware('api')->group(function () {
    Route::post('/paypal/webhook', 'PaypalController@webhook')->name('paypal.webhook');

    Route::prefix('public')->name('public.')->group(function () {
        Route::get('plans', 'HomeController@plans')->name('login');
    });

    Route::namespace('Auth')->prefix('auth')->name('auth.')->group(function () {
        Route::post('login', 'AuthController@login')->name('login');
        Route::post('logout', 'AuthController@logout')->name('logout');
        Route::post('refresh', 'AuthController@refresh')->name('refresh');
        Route::put('termsuse', 'AuthController@termsuse')->name('termsuse');
        Route::post('social/{provider}', 'AuthSocialController@login')->name('social');
    });

    Route::middleware('auth:api')->group(function () {
        Route::get('/me', 'ProfileController@me')->name('me');
        Route::put('/me', 'ProfileController@update')->name('me.update');

        Route::post('/paypal/purchase', 'PaypalController@purchase')->name('paypal.purchase');

        Route::get('/roles', 'RoleController@index')->name('roles.index');

        Route::resource('/users', 'UserController');
        Route::post('/users/{user}/plans', 'UserController@plan')->name('users.plan');
        Route::put('/users/{user}/block', 'UserController@block')->name('users.block');
        Route::put('/users/{user}/password', 'UserController@password')->name('users.password');

        Route::resource('/plans', 'PlanController');
        Route::resource('/instructions', 'InstructionController');
        Route::resource('/menus', 'CombinationMenuController');
        Route::resource('/submenus', 'CombinationSubmenuController');
        Route::resource('/links', 'CombinationLinkController');

        Route::post('/users/{user}/combinations', 'UserCombinationController@save')->name('user.combinations.save');
        Route::put('/users/{user}/combinations/{combinationUser}/update', 'UserCombinationController@update')->name('user.combinations.update');
        Route::delete('/users/{user}/combinations/{combinationUser}', 'UserCombinationController@destroy')->name('user.combinations.destroy');

        Route::post('/users/{user}/combinations/{combinationUser}/cells', 'UserCombinationController@addCells')->name('user.combinations.cells.add');
        Route::put('/users/{user}/combinations/{combinationUser}/cells', 'UserCombinationController@removeCells')->name('user.combinations.cells.remove');

        Route::get('/users/{user}/combinations/links/{link}', 'UserCombinationController@findByLink')->name('user.combinations.findByLink');

        Route::get('/combinations/menus', 'CombinationController@menus')->name('combinations.menus');
        Route::get('/combinations/table', 'CombinationController@table')->name('combinations.table');
    });

});
