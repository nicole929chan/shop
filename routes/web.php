<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', 'Admin\Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Admin\Auth\LoginController@login');
Route::post('logout', 'Admin\Auth\LoginController@logout')->name('logout');

Route::get('manager/create', 'Admin\Manager\ManagerController@create')->name('manager.create');
Route::get('manager/{member}', 'Admin\Manager\ManagerController@show')->name('manager.show');
Route::get('manager', 'Admin\Manager\ManagerController@index')->name('manager.index');
Route::post('manager', 'Admin\Manager\ManagerController@store');

Route::post('activity', 'Admin\Manager\ActivityController@store')->name('activity.store');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('members/{member}', 'Admin\Member\MemberController@show')->name('member.show');
Route::get('users/{member}', 'Admin\Member\UserController@index')->name('user.index');

Route::get('getPoints/{code}', 'Admin\Point\PointController@getPoints')->name('getPoints');
Route::post('getPoints', 'Admin\Point\PointController@store');