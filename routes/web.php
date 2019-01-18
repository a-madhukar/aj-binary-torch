<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('houses', 'HousesController@index'); 