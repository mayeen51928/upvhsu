<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Auth::routes();
Route::get('/home', 'HomeController@index');


/* ROUTES FOR PATIENT ACCOUNT */
Route::get('/account','PatientController@dashboard');
Route::get('/account/profile','PatientController@profile');
Route::get('/account/visits','PatientController@visits');
Route::get('/account/bills','PatientController@bills');

/* ROUTES FOR DENTIST ACCOUNT */
Route::get('/dentist','DentistController@dashboard');
Route::get('/dentist/profile','DentistController@profile');
Route::get('/dentist/manageschedule','DentistController@manageschedule');
Route::get('/dentist/searchpatient','DentistController@searchpatient');

/* ROUTES FOR CASHIER ACCOUNT */
Route::get('/cashier','CashierController@dashboard');
Route::get('/cashier/profile','CashierController@profile');
Route::get('/cashier/searchpatient','CashierController@searchpatient');
