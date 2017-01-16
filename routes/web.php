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

Route::get('/', 'PagesController@index');

Auth::routes();
Route::get('/home', 'HomeController@index');
Route::get('/scheduleappointment', 'PagesController@scheduleappointment');
Route::post('/displayschedule_dental', 'PagesController@displayscheduledental');
Route::post('/displayschedule_medical', 'PagesController@displayschedulemedical');
Route::post('/createappointment_dental', 'PagesController@createappointmentdental');
Route::post('/createappointment_medical', 'PagesController@createappointmentmedical');

/* ROUTES FOR PATIENT ACCOUNT */
Route::get('/account','PatientController@dashboard');
Route::get('/account/profile','PatientController@profile');
<<<<<<< HEAD
=======
Route::get('/account/profile/edit','PatientController@editprofile');
Route::post('/account/profile/update','PatientController@updateprofile');
>>>>>>> 0f2f8a95bb388be73e732df8f4b0dcc3ff26f14d
Route::get('/account/visits','PatientController@visits');
Route::get('/account/bills','PatientController@bills');

/* ROUTES FOR DENTIST ACCOUNT */
Route::get('/dentist','DentistController@dashboard');
Route::get('/dentist/profile','DentistController@profile');
Route::get('/dentist/profile/edit','DentistController@editprofile');
Route::post('/dentist/profile/update','DentistController@updateprofile');
Route::get('/dentist/manageschedule','DentistController@manageschedule');
Route::get('/dentist/searchpatient','DentistController@searchpatient');
Route::post('/addschedule_dental', 'DentistController@addschedule');
Route::post('/addrecord_dental', 'DentistController@addrecord');
Route::post('/addrecord_dental_teeth', 'DentistController@addrecordperteeth');
Route::post('/update_dental_teeth', 'DentistController@updaterecordperteeth');

/* ROUTES FOR MEDICAL DOCTOR ACCOUNT */
Route::get('/doctor','DoctorController@dashboard');
Route::get('/doctor/profile','DoctorController@profile');
Route::get('/doctor/profile/edit','DoctorController@editprofile');
Route::post('/doctor/profile/update','DoctorController@updateprofile');
Route::get('/doctor/manageschedule','DoctorController@manageschedule');
Route::get('/doctor/searchpatient','DoctorController@searchpatient');
Route::post('/addschedule_medical', 'DoctorController@addschedule');

/* ROUTES FOR LABORATORY ACCOUNT */
Route::get('/lab','LabController@dashboard');
Route::get('/lab/profile','LabController@profile');
Route::get('/lab/profile/edit','LabController@editprofile');
Route::post('/lab/profile/update','LabController@updateprofile');
Route::get('/lab/searchpatient','LabController@searchpatient');

/* ROUTES FOR XRAY ACCOUNT */
Route::get('/xray','XrayController@dashboard');
Route::get('/xray/profile','XrayController@profile');
Route::get('/xray/profile/edit','XrayController@editprofile');
Route::post('/xray/profile/update','XrayController@updateprofile');
Route::get('/xray/searchpatient','XrayController@searchpatient');

/* ROUTES FOR CASHIER ACCOUNT */
Route::get('/cashier','CashierController@dashboard');
Route::get('/cashier/profile','CashierController@profile');
Route::get('/cashier/profile/edit','CashierController@editprofile');
Route::post('/cashier/profile/update','CashierController@updateprofile');
Route::get('/cashier/searchpatient','CashierController@searchpatient');
