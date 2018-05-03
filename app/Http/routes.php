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

// Search tools
Route::get('search', ['uses' => 'SportController@search']);

// Board
Route::get('/', 'SportController@getSports');
Route::get('sport/{slug}', 'SportController@getAreas');
Route::get('sport/{slug}/map', 'SportController@getAreasWithMap');

// Hot Matches
Route::get('sport/{slug}/hot-matches', 'SportController@getHotMatches');

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
    Route::post('store-match-ajax', 'MatchAjaxController@storeMatch');

    Route::post('join-match/{match_id}', 'MatchController@joinMatch');
    Route::post('join-match-ajax/{match_id}', 'MatchAjaxController@joinMatch');

    Route::post('left-match/{match_id}', 'MatchController@leftMatch');
    Route::post('left-match-ajax/{match_id}', 'MatchAjaxController@leftMatch');

    // Chat
    Route::post('chat/message/{match_id}', 'ChatController@postMessage');
    Route::post('chat/message-ajax/{match_id}', 'ChatController@postMessageAjax');

    // Balance and Payment
    Route::get('my-balance', 'ProfileController@balance');
    Route::post('top-up-balance', 'ProfileController@topUpBalance');
    Route::get('payment', 'ProfileController@payment');

    // Profile
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
    Route::get('feedback', 'UserController@feedback');
    Route::post('feedback', 'UserController@storeFeedback');
});

    Route::any('postlink', 'ProfileController@postlink');

Route::get('post', function() {

    $path = __DIR__.'/Controllers/Epay/paysys/kkb.utils.php';
    $path1 = __DIR__.'/Controllers/Epay/abusport_paysys/config.txt';

    \File::requireOnce($path);

    $post = unserialize('a:1:{s:8:"response";s:872:"<document><bank name="Kazkommertsbank JSC"><customer name="ADILET ISSAYEV" mail="is.adilet@mail.ru" phone=""><merchant cert_id="c183e872" name="ABUSPORT TOO"><order order_id="000030" amount="10" currency="398"><department merchant_id="98837431" amount="10"/></order></merchant><merchant_sign type="RSA"/></customer><customer_sign type="RSA"/><results timestamp="2018-05-03 17:53:08"><payment merchant_id="98837431" card="400303-XX-XXXX-7573" amount="10.00" reference="812381947632" approval_code="886892" response_code="00" Secure="No" card_bin="KAZ" c_hash="F142AA394586ADDC4F309A1369B88731" exp_date="05/2022"/></results></bank><bank_sign cert_id="00c183d6c3" type="SHA/RSA">2IDTEGuZfIhmwpu9e5gO4gFg9etH6wT2cMsff4BUGW4+/LMT1CWrY8AQExp0RBSYGXg1FrEdF3n+v0lgUkqaHnad38KyUlzp1HL7Jy4YtFu/8YSgoKBVde69Mt6IOhBp0DHZSWSjWC05gKL/7eiKvuRCFI89vrVzn3O6wXTgFAw=</bank_sign></document>";}');

    $result = process_response(stripslashes($post['response']), $path1);

    if (is_array($result)) {

        if (in_array("ERROR", $result)) {

            if ($result["ERROR_TYPE"] == "ERROR") {
                echo "System error:".$result["ERROR"];
            }
            elseif ($result["ERROR_TYPE"] == "system") {
                echo "Bank system error > Code: '".$result["ERROR_CODE"]."' Text: '".$result["ERROR_CHARDATA"]."' Time: '".$result["ERROR_TIME"]."' Order_ID: '".$result["RESPONSE_ORDER_ID"]."'";
            }
            elseif ($result["ERROR_TYPE"] == "auth") {
                echo "Bank system user autentication error > Code: '".$result["ERROR_CODE"]."' Text: '".$result["ERROR_CHARDATA"]."' Time: '".$result["ERROR_TIME"]."' Order_ID: '".$result["RESPONSE_ORDER_ID"]."'";
            }
        }

        if (in_array("DOCUMENT", $result)) {

            $user = \Auth::user();
            $balance = (int) $user->balance + $result['PAYMENT_AMOUNT'];
            $user->balance = $balance;
            $user->save();

            // $payment_id = (int) round($result['ORDER_ORDER_ID']);
            $payment_id = 16;
            $payment = \App\Payment::find($payment_id);
            $payment->status = true;
            $payment->save();

            return 0;

            /*echo "Result DATA: <br>";
            foreach ($result as $key => $value)
            {
                echo "Postlink Result: ".$key." = ".$value."<br>";
            }*/
        }
    }
    else {
        echo "System error".$result;
    }

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
Route::post('api/requestaddmessage/','ApiController@postMessageAjax');
Route::post('api/message-ajax/{match_id}/{user_id}', 'ApiController@postMessageAjax');
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
