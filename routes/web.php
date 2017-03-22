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
Route::get('/about', 'PagesController@about');
Route::get('/scheduleappointment', 'PagesController@scheduleappointment');
Route::get('/announcements', 'PagesController@announcements');
Route::post('/announcement/edit','PagesController@editannouncement');
Route::post('/announcement/update','PagesController@updateannouncement');
Route::post('/announcement/delete','PagesController@deleteannouncement');
Route::get('/medicalstaff', 'PagesController@medicalstaff');
Route::post('/viewmedicalstaffinfo', 'PagesController@viewmedicalstaffinfo');
Route::post('/displayschedule_dental', 'PagesController@displayscheduledental');
Route::post('/displayschedule_medical', 'PagesController@displayschedulemedical');
Route::post('/createappointment_dental', 'PagesController@createappointmentdental');
Route::post('/createappointment_medical', 'PagesController@createappointmentmedical');
Route::post('/loginfromdentalappointment', 'PagesController@loginfromdentalappointment');
Route::post('/loginfrommedicalappointment', 'PagesController@loginfrommedicalappointment');
Route::post('/signupfromdentalappointment', 'PagesController@signupfromdentalappointment');
Route::post('/signupfrommedicalappointment', 'PagesController@signupfrommedicalappointment');

/* ROUTES FOR PATIENT ACCOUNT */
Route::get('/account','PatientController@dashboard');
Route::post('/getremarkspatientdashboard', 'PatientController@getremarkspatientdashboard');
Route::get('/account/profile','PatientController@profile');
Route::get('/account/profile/edit','PatientController@editprofile');
Route::post('/account/profile/update','PatientController@updateprofile');
Route::get('/account/visits','PatientController@visits');
Route::post('/view_dental_record','PatientController@viewdentalrecord');
Route::post('/view_dental_record_dashboard','PatientController@viewdentalrecorddashboard');
Route::post('/view_medical_record_dashboard','PatientController@viewmedicalrecorddashboard');
Route::post('/print_medical_receipt','PatientController@printmedicalreceipt');

/* ROUTES FOR DENTIST ACCOUNT */
Route::get('/dentist','DentistController@dashboard');
Route::post('/totalnumberofdentalpatients', 'DentistController@totalnumberofdentalpatients');
Route::post('/dentist/updatestaffnotes', 'DentistController@updatestaffnotes');
Route::get('/dentist/profile','DentistController@profile');
Route::get('/dentist/profile/edit','DentistController@editprofile');
Route::post('/dentist/profile/update','DentistController@updateprofile');
Route::get('/dentist/manageschedule','DentistController@manageschedule');
Route::get('/dentist/searchpatient','DentistController@searchpatient');
Route::post('/searchpatientnamerecorddental', 'DentistController@searchpatientnamerecorddental');
Route::post('/displaypatientrecordsearchdental', 'DentistController@displaypatientrecordsearchdental');
Route::get('/dentist/viewrecords/{id}', 'DentistController@viewrecords');
Route::get('/dentist/searchpatient/date', 'DentistController@searchpatientbydate');
Route::post('/searchpatientbydaterecorddental', 'DentistController@searchpatientbydaterecorddental');
Route::get('/dentist/viewdentalrecord/{id}', 'DentistController@viewdentalrecord');
Route::post('/addschedule_dental', 'DentistController@addschedule');
Route::get('/dentist/updatedentalrecord/{id}','DentistController@updatedentalrecord');
Route::post('/update_dental_record_modal','DentistController@updatedentalrecordmodal');
Route::post('/insert_dental_record_modal','DentistController@insertdentalrecordmodal');
Route::post('/update_dental_diagnosis','DentistController@updatedentaldiagnosis');
Route::post('/hover_dental_chart','DentistController@hoverdentalchart');
Route::post('/additional_dental_record','DentistController@additionaldentalrecord');
Route::post('/add_billing_dental','DentistController@addbillingdental');
Route::post('/confirm_billing_dental','DentistController@confirmbillingdental');

/* ROUTES FOR MEDICAL DOCTOR ACCOUNT */
Route::get('/doctor','DoctorController@dashboard');
Route::post('/totalnumberofpatients', 'DoctorController@totalnumberofpatients');
Route::post('/doctor/updatestaffnotes', 'DoctorController@updatestaffnotes');
Route::get('/doctor/profile','DoctorController@profile');
Route::get('/doctor/profile/edit','DoctorController@editprofile');
Route::post('/doctor/profile/update','DoctorController@updateprofile');
Route::get('/doctor/manageschedule','DoctorController@manageschedule');
Route::get('/doctor/searchpatient','DoctorController@searchpatient');
Route::get('/doctor/searchpatient/date', 'DoctorController@searchpatientbydate');
Route::post('/searchpatientnamerecord','DoctorController@searchpatientnamerecord');
Route::post('/searchpatientbydaterecord', 'DoctorController@searchpatientbydaterecord');
Route::get('/doctor/viewrecords/{id}', 'DoctorController@viewrecords');
Route::get('/doctor/addrecords/{id}', 'DoctorController@addrecordswithoutappointment');
Route::post('/doctor/addrecord', 'DoctorController@addrecord');
Route::post('/displaypatientrecordsearch','DoctorController@displaypatientrecordsearch');
Route::post('/viewindividualrecordfromsearch', 'DoctorController@viewindividualrecordfromsearch');
Route::post('/addschedule_medical', 'DoctorController@addschedule');
Route::post('/viewmedicaldiagnosis', 'DoctorController@viewmedicaldiagnosis');
Route::post('/addmedicaldiagnosis', 'DoctorController@addmedicaldiagnosis');
Route::post('/updatemedicaldiagnosis', 'DoctorController@updatemedicaldiagnosis');
Route::post('/add_billing_medical','DoctorController@addbillingmedical');
Route::post('/confirm_billing_medical','DoctorController@confirmbillingmedical');

/* ROUTES FOR LABORATORY ACCOUNT */
Route::get('/lab','LabController@dashboard');
// Route::post('/addcbcresult','LabController@addcbcresult');
// Route::post('/adddrugtestresult', 'LabController@adddrugtestresult');
// Route::post('/addfecalysisresult', 'LabController@addfecalysisresult');
// Route::post('/addurinalysisresult', 'LabController@addurinalysisresult');
Route::post('/viewlabdiagnosis', 'LabController@viewlabdiagnosis');
Route::post('/updatelabdiagnosis', 'LabController@updatelabdiagnosis');
Route::get('/lab/profile','LabController@profile');
Route::get('/lab/profile/edit','LabController@editprofile');
Route::post('/lab/profile/update','LabController@updateprofile');
Route::get('/lab/searchpatient','LabController@searchpatient');
Route::post('/add_billing_lab','LabController@addbillinglab');
Route::post('/confirm_billing_lab','LabController@confirmbillinglab');


/* ROUTES FOR XRAY ACCOUNT */
Route::get('/xray','XrayController@dashboard');
Route::post('/addxrayresult', 'XrayController@addxrayresult');
Route::post('/viewxraydiagnosis', 'XrayController@viewxraydiagnosis');
Route::get('/xray/profile','XrayController@profile');
Route::get('/xray/profile/edit','XrayController@editprofile');
Route::post('/xray/profile/update','XrayController@updateprofile');
Route::get('/xray/searchpatient','XrayController@searchpatient');
Route::post('/add_billing_xray','XrayController@addbillingxray');
Route::post('/confirm_billing_xray','XrayController@confirmbillingxray');

/* ROUTES FOR CASHIER ACCOUNT */
Route::get('/cashier','CashierController@dashboard');
Route::get('/cashier/profile','CashierController@profile');
Route::get('/cashier/profile/edit','CashierController@editprofile');
Route::post('/cashier/profile/update','CashierController@updateprofile');
Route::get('/cashier/searchpatient','CashierController@searchpatient');
Route::post('/confirm_medical_billing','CashierController@confirmmedicalbilling');
Route::post('/display_medical_billing','CashierController@displaymedicalbilling');
Route::post('/cashier/billingtoday','CashierController@billingtoday');

/* ROUTES FOR ADMIN ACCOUNT */
Route::get('/admin', 'AdminController@dashboard');
Route::post('/admingraphdata', 'AdminController@admingraphdata');
Route::get('/admin/announcement', 'AdminController@announcement');
Route::get('/admin/addaccount', 'AdminController@addaccount');
Route::post('/admin/createstaffaccount', 'AdminController@createstaffaccount');
Route::post('/admin/postannouncement', 'AdminController@postannouncement');
Route::get('/admin/addstudent', 'AdminController@addstudent');
Route::post('/admin/createstudent', 'AdminController@createstudent');
Route::get('/admin/editservices', 'AdminController@modifyservices');
Route::get('/admin/generateschedule', 'AdminController@generateschedule');
Route::post('/display_medical_services', 'AdminController@viewservicesmedical');
Route::post('/display_dental_services', 'AdminController@viewservicesdental');
Route::post('/edit_medical_services', 'AdminController@editmedicalservices');
Route::post('/update_medical_services', 'AdminController@updatemedicalservices');

//For wrong URLs
// Route::get('/{any}', function($any){
// 	return back();
// })->where('any', '.*');