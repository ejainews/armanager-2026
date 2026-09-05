<?php

/*
| Developed By: Sitehandy Solutions
| Developer URI: https://sitehandy.com
| Version: 2.0.0
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'install'], function() {
    Route::get('/', 'InstallController@index')->name('install.index');
    Route::post('/', 'InstallController@storeLicense')->name('install.store.license');
    Route::get('/final', 'InstallController@final')->name('install.final');
    Route::post('/final', 'InstallController@storeFinal')->name('install.store.final');
    Route::get('/completed', 'InstallController@completed')->name('install.completed');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth', 'installed'])->group(function () {

    Route::get('profile', 'ProfileController@edit')->name('profile.edit');
    Route::patch('profile', 'ProfileController@update')->name('profile.update');

    Route::post('projects/datatables', 'ProjectController@datatables')->name('projects.datatables');
    Route::post('projects/{project}/datatables', 'ProjectAutoresponderController@datatables')->name('projects.autoresponders.datatables');
    Route::post('projects/{project}/replicate', 'ProjectController@replicate')->name('projects.replicate');
    Route::get('projects/{project}/subscribers', 'ProjectSubscriberController@index')->name('projects.subscribers.index');
    Route::post('projects/{project}/subscribers/datatables', 'ProjectSubscriberController@datatables')->name('projects.subscribers.datatables');
    Route::resource('projects', 'ProjectController');

    Route::post('autoresponders/datatables', 'AutoresponderController@datatables')->name('autoresponders.datatables');
    Route::resource('autoresponders', 'AutoresponderController');
    Route::post('subscribers/datatables', 'SubscriberController@datatables')->name('subscribers.datatables');
    Route::resource('subscribers', 'SubscriberController');

});

Route::get('/sync/{code?}', 'ApiController@sync')->name('api.sync');
Route::get('/{code}', 'ApiController@index')->name('api.index');
