<?php

// Authentication routes...
Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthCustomController@postLogin');
Route::get('logout', 'Auth\AuthCustomController@getLogout');

// Registration routes...
Route::get('register', 'Auth\AuthController@getRegister');
Route::post('register', 'Auth\AuthCustomController@postRegister');
// Route::get('confirm/{token}', 'Auth\AuthCustomController@confirm');

// Confirmation of registration
Route::get('confirm-register', 'Auth\AuthCustomController@getConfirmRegister');
Route::post('confirm-register', 'Auth\AuthCustomController@postConfirmRegister');

// Password reset link request routes...
// Route::get('password/email', 'Auth\PasswordController@getEmail');
// Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
// Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
// Route::post('password/reset', 'Auth\PasswordController@postReset');

// Board
Route::get('/', 'SportController@getSports');
Route::get('sport/{slug}', 'SportController@getAreas');
Route::get('sport/{slug}/map', 'SportController@getAreasWithMap');

Route::get('sport/{slug}/{area_id}/calendar/{setDays?}', 'SportController@getMatchesWithCalendar');
Route::get('sport/{slug}/{area_id}/matches/{date?}', 'SportController@getMatches');
Route::get('sport/{slug}/{area_id}/info', 'SportController@getInfo');

Route::group(['middleware' => 'auth'], function() {

    // Match
    // Route::get('create-match/{setDays?}', 'MatchController@createMatch');
    Route::get('sport/{slug}/{area_id}/create-match/{setDays?}', 'MatchController@createMatchInArea');
    Route::get('sport/{slug}/{area_id}/match/{match_id}/', 'MatchController@getMatch');
    Route::get('sport/{slug}/{area_id}/match-chat/{match_id}/', 'MatchController@getChat');

    Route::post('store-match', 'MatchController@storeMatch');
    Route::post('store-match-ajax', 'MatchController@storeMatchAjax');

    Route::post('join-match/{match_id}', 'MatchController@joinMatch');
    Route::post('join-match-ajax/{match_id}', 'MatchController@joinMatchAjax');

    Route::post('left-match/{match_id}', 'MatchController@leftMatch');
    Route::post('left-match-ajax/{match_id}', 'MatchController@leftMatchAjax');

    Route::post('chat/message/{match_id}', 'ChatController@postMessage');
    Route::post('chat/message-ajax/{match_id}', 'ChatController@postMessageAjax');

    // Profile
    Route::get('my-balance', 'ProfileController@balance');
    Route::post('top-up-balance', 'ProfileController@topUpBalance');
    Route::get('my-profile', 'ProfileController@profile');
    Route::post('my-profile', 'ProfileController@updateProfile');
    Route::get('my-profile/edit', 'ProfileController@editProfile');
    Route::get('my-matches', 'ProfileController@myMatches');

    // Users
    Route::get('friends', 'UserController@myFriends');
    Route::get('all-users', 'UserController@allUsers');
    Route::get('user-profile/{id}', 'UserController@userProfile');
    Route::get('add-to-friends/{id}', 'UserController@addToFriends');
    Route::get('accept/{id}', 'UserController@accept');
});


// Administration
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role:root', 'role:admin']], function () {

    Route::get('/', 'Admin\AdminController@index');
    Route::resource('pages', 'Admin\PageController');
    Route::resource('users', 'Admin\UserController');
    Route::resource('organizations', 'Admin\OrganizationController');
    Route::resource('org_types', 'Admin\OrgTypeController');
    Route::resource('roles', 'Admin\RoleController');
    Route::resource('permissions', 'Admin\PermissionController');

    Route::resource('countries', 'Admin\CountryController');
    Route::resource('cities', 'Admin\CityController');
    Route::resource('districts', 'Admin\DistrictController');

    Route::resource('sports', 'Admin\SportController');
    Route::resource('areas', 'Admin\AreaController');
    Route::resource('fields', 'Admin\FieldController');
    Route::resource('schedules', 'Admin\ScheduleController');
    Route::resource('options', 'Admin\OptionController');
    Route::resource('matches', 'Admin\MatchController');
});


// Client Area Administration
Route::group(['prefix' => 'panel', 'middleware' => ['auth', 'role:area-admin']], function () {

    Route::get('/', 'AreaAdmin\AdminController@index');
    Route::resource('admin-organization', 'AreaAdmin\OrganizationController');
    Route::resource('admin-areas', 'AreaAdmin\AreaController');
    Route::resource('admin-fields', 'AreaAdmin\FieldController');
    Route::resource('admin-schedules', 'AreaAdmin\ScheduleController');

    // Matches control
    Route::get('admin-matches/{time?}', 'AreaAdmin\MatchController@index');
    Route::get('admin-matches/{id}/start', 'AreaAdmin\MatchController@start');
    Route::get('admin-matches-ajax/{id}', 'AreaAdmin\MatchController@ajaxStart');
    Route::delete('admin-matches/{id}', 'AreaAdmin\MatchController@destroy');
});


// Api
Route::post('api/requestmessages/','ApiController@requestmessages');
Route::post('api/requestaddmessage/','ApiController@requestaddmessage');
Route::post('api/requestprofile/','ApiController@requestprofile');
Route::get('api/requestcallbacklist/{userid}','ApiController@requestcallbacklist');
Route::post('api/requestnewcallback/','ApiController@requestnewcallback');
Route::get('api/requestlogin/{phone}/{password}','ApiController@requestlogin');
Route::get('api/requestsms/{mobile}/{name}/{surname}/{email}/{password}/{sex}','ApiController@requestsms');
Route::get('api/requestverifyotp/{otp}','ApiController@requestverifyotp');
Route::get('api/requestsports','ApiController@requestsports');
Route::get('api/requestplaygrounds/{sportid}','ApiController@requestplaygrounds');  
Route::get('api/requestmatches/{areaid}','ApiController@requestmatches');
Route::get('api/requestmatchplayers/{matchid}','ApiController@requestmatchplayers');
Route::get('api/requestjoinmatch/{matchid}/{userid}','ApiController@requestjoinmatch');
Route::get('api/requestexitmatch/{matchid}/{userid}','ApiController@requestexitmatch');
Route::get('api/requestweekdays/{playgroundid}/{selecteddate}','ApiController@requestweekdays');
Route::post('api/requestmatchcreate/','ApiController@requestmatchcreate');
Route::post('api/requestsign64/','ApiController@requestsign64');

// Test