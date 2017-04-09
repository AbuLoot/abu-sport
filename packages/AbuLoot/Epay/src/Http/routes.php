<?php

Route::get('payment/{amount}', 'AbuLoot\Epay\Http\Controllers\EpayController@index'); 
Route::get('epay/test', 'AbuLoot\Epay\Http\Controllers\EpayController@test');
