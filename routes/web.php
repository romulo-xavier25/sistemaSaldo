<?php


Route::group(['middleware' => ['auth'], 'namespace' => 'Admin', 'prefix' => 'admin'], function() {
    Route::get('/', 'AdminController@index')->name('admin.home');
    Route::get('/', 'AdminController@index')->name('admin.home');
    Route::get('balance', 'BalanceController@index')->name('admin.balance');
    Route::get('balance/deposit', 'BalanceController@deposit')->name('balance.deposit');
    Route::post('balance/deposit', 'BalanceController@depositStore')->name('deposit.store');
    Route::get('withdraw', 'BalanceController@withdraw')->name('balance.withdraw');
    Route::post('withdraw', 'BalanceController@withdrawStore')->name('withdraw.store');
    Route::get('transfer', 'BalanceController@transfer')->name('balance.transfer');
    Route::post('confirmTransfer', 'BalanceController@confirmTransfer')->name('confirm.transfer');
    Route::post('transfer', 'BalanceController@transferStore')->name('transfer.store');
    Route::get('historic', 'BalanceController@historic')->name('admin.historic');
});

Route::get('/', 'Site\SiteController@index')->name('home');

Auth::routes();

