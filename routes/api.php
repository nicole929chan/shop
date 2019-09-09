<?php

Route::group(['prefix' => 'auth'], function() {
    Route::post('register', 'Auth\RegisterController@action');
    Route::post('login', 'Auth\LoginController@action');
    Route::get('me', 'Auth\MeController@action');
});
Route::post('logout', 'Auth\LogoutController@logout');

Route::get('members/{member}', 'Members\MemberController@show');
Route::get('members', 'Members\MemberController@index');

Route::resource('plan', 'Plan\PlanController', [
    'parameters' => [
        'plan' => 'member'
    ]
]);

Route::get('user/{user}/plans', 'Plan\UserPlansController@action');