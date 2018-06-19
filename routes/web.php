<?php
// Login Controller

Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/', 'Auth\LoginController@login');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

// Profile Controller

Route::get('/profile/edit', 'Auth\ProfileController@edit')->name('profile_edit');
Route::post('/profile/update', 'Auth\ProfileController@update')->name('profile_update');

// Home Controller

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/imprint', 'HomeController@imprint')->name('imprint');
Route::get('/db', 'HomeController@db')->name('db');

// Staff Controller

Route::get('/staff', 'StaffController@index')->name('staff');

Route::get('/staff/create', 'StaffController@create')->name('staff_create');
Route::post('/staff/store', 'StaffController@store')->name('staff_store');

Route::get('/staff/archive/{user_id}', 'StaffController@archive')->name('staff_archive');
Route::get('/staff/archived', 'StaffController@archived')->name('staff_archived');
Route::get('/staff/un_archive/{user_id}', 'StaffController@unArchive')->name('staff_un_archive');

Route::get('/staff/vacation', 'StaffController@vacation')->name('staff_vacation');
Route::get('/staff/vacation/personal', 'StaffController@vacationPersonal')->name('staff_vacation_personal');
Route::get('/staff/vacation/create', 'StaffController@vacationCreate')->name('staff_vacation_create');
Route::post('/staff/vacation/store', 'StaffController@vacationStore')->name('staff_vacation_store');
Route::get('/staff/vacation/requested', 'StaffController@vacationRequested')->name('staff_vacation_requested');
Route::get('/staff/vacation/rejected', 'StaffController@vacationRejected')->name('staff_vacation_rejected');
Route::get('/staff/vacation/approve/{vacation_id}', 'StaffController@vacationApprove')->name('staff_vacation_approve');
Route::get('/staff/vacation/reject/{vacation_id}', 'StaffController@vacationReject')->name('staff_vacation_reject');
Route::get('/staff/vacation/edit/{vacation_id}', 'StaffController@vacationEdit')->name('staff_vacation_edit');
Route::post('/staff/vacation/update/{vacation_id}', 'StaffController@vacationUpdate')->name('staff_vacation_update');
Route::get('/staff/vacation/delete/{vacation_id}', 'StaffController@vacationDelete')->name('staff_vacation_delete');

Route::get('/staff/pdf', 'StaffController@pdf')->name('staff_pdf');

Route::get('/staff/show/{user_id}', 'StaffController@show')->name('staff_show');
Route::get('/staff/show/pdf/{user_id}', 'StaffController@showPdf')->name('staff_show_pdf');

Route::get('/staff/edit/{user_id}', 'StaffController@edit')->name('staff_edit');
Route::post('/staff/update/{user_id}', 'StaffController@update')->name('staff_update');

Route::get('/staff/delete/{user_id}', 'StaffController@delete')->name('staff_delete');

// Client Controller

Route::get('/client', 'ClientController@index')->name('client');

Route::get('/client/create', 'ClientController@create')->name('client_create');
Route::post('/client/store', 'ClientController@store')->name('client_store');

Route::get('/client/archive/{client_id}', 'ClientController@archive')->name('client_archive');
Route::get('/client/archived', 'ClientController@archived')->name('client_archived');
Route::get('/client/un_archive/{client_id}', 'ClientController@unArchive')->name('client_un_archive');

Route::get('/client/pdf', 'ClientController@pdf')->name('client_pdf');

Route::get('/client/show/{client_id}', 'ClientController@show')->name('client_show');
Route::get('/client/show/pdf/{client_id}', 'ClientController@showPdf')->name('client_show_pdf');

Route::get('/client/edit/{client_id}', 'ClientController@edit')->name('client_edit');
Route::post('/client/update/{client_id}', 'ClientController@update')->name('client_update');

Route::get('/client/delete/{client_id}', 'ClientController@delete')->name('client_delete');

// Report Controller

Route::get('/report', 'ReportController@index')->name('report');

Route::get('/report/create', 'ReportController@create')->name('report_create');
Route::post('/report/store', 'ReportController@store')->name('report_store');

Route::get('/report/pdf', 'ReportController@pdf')->name('report_pdf');

Route::get('/report/edit/{report_id}', 'ReportController@edit')->name('report_edit');
Route::post('/report/update/{report_id}', 'ReportController@update')->name('report_update');

Route::get('/report/delete/{report_id}', 'ReportController@delete')->name('report_delete');

// Theft Controller

Route::get('/theft', 'TheftController@index')->name('theft');

Route::get('/theft/create', 'TheftController@create')->name('theft_create');
Route::post('/theft/store', 'TheftController@store')->name('theft_store');

Route::get('/theft/pdf', 'TheftController@pdf')->name('theft_pdf');

Route::get('/theft/ajax/{document_id}', 'TheftController@ajax')->name('theft_ajax');
Route::post('/theft/update_files/{theft_id}', 'TheftController@updateFiles')->name('theft_update_files');
Route::get('/theft/delete_file/{theft_id}/{file_name}', 'TheftController@deleteFile')->name('theft_delete_file');

Route::get('/theft/edit/{theft_id}', 'TheftController@edit')->name('theft_edit');
Route::post('/theft/update/{theft_id}', 'TheftController@update')->name('theft_update');

Route::get('/report/delete/{theft_id}', 'TheftController@delete')->name('theft_delete');

// Warehouse Controller

Route::get('/warehouse', 'WarehouseController@index')->name('warehouse');
Route::get('/warehouse/returns', 'WarehouseController@transactions')->name('warehouse_returns');
Route::get('/warehouse/transactions', 'WarehouseController@transactions')->name('warehouse_transactions');
Route::get('/warehouse/staff', 'WarehouseController@staff')->name('warehouse_staff');
Route::get('/warehouse/material', 'WarehouseController@material')->name('warehouse_material');

Route::get('/warehouse/create', 'WarehouseController@create')->name('warehouse_create');
Route::post('/warehouse/store', 'WarehouseController@store')->name('warehouse_store');

Route::get('/warehouse/input/{warehouse}', 'WarehouseController@getInput')->name('warehouse_input');
Route::post('/warehouse/input/{warehouse}/update', 'WarehouseController@postInput')->name('warehouse_input_update');
Route::get('/warehouse/output/{warehouse}', 'WarehouseController@getOutput')->name('warehouse_output');
Route::post('/warehouse/output/{warehouse}/update', 'WarehouseController@postOutput')->name('warehouse_output_update');

Route::get('/warehouse/edit/{warehouse}', 'WarehouseController@edit')->name('warehouse_edit');
Route::post('/warehouse/update/{warehouse}', 'WarehouseController@update')->name('warehouse_update');

Route::get('/warehouse/delete/{warehouse}', 'WarehouseController@delete')->name('warehouse_delete');

// Event Controller

Route::get('/event', 'EventController@index')->name('event');

Route::get('/event/create', [
    'as' => 'event_create',
    'uses' => 'EventController@create',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);
Route::post('/event/store', [
    'as' => 'event_store',
    'uses' => 'EventController@store',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);

Route::get('/event/old', [
    'as' => 'event_old',
    'uses' => 'EventController@old',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);

Route::get('/event/archive/{event_id}', [
    'as' => 'event_archive',
    'uses' => 'EventController@archive',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);
Route::get('/event/un_archive/{event_id}', [
    'as' => 'event_un_archive',
    'uses' => 'EventController@un_archive',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);
Route::get('/event/archived', [
    'as' => 'event_archived',
    'uses' => 'EventController@archived',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);

Route::get('/event/users/{event_id}', [
    'as' => 'event_users',
    'uses' => 'EventController@users',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);
Route::get('/event/{event_id}/users/create', [
    'as' => 'event_user_create',
    'uses' => 'EventController@createUser',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);
Route::get('/event/{event_id}/users/{user_id}/store', [
    'as' => 'event_user_store',
    'uses' => 'EventController@storeUser',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);

Route::post('/event/{event_id}/users/signup', [
    'as' => 'event_user_signup',
    'uses' => 'EventController@signUpUser',
    'middleware' => 'roles',
    'roles' => ['Main Organizer', 'Security', 'Guard', 'Detective']
]);

Route::post('/event/{event_id}/users/signout', [
    'as' => 'event_user_signout',
    'uses' => 'EventController@signOutUser',
    'middleware' => 'roles',
    'roles' => ['Main Organizer', 'Security', 'Guard', 'Detective']
]);

Route::get('/event/{event_id}/users/accept/{user_id}', [
    'as' => 'event_user_accept',
    'uses' => 'EventController@user_accept',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);
Route::get('/event/{event_id}/users/unaccept/{user_id}', [
    'as' => 'event_user_unaccept',
    'uses' => 'EventController@user_unaccept',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);
Route::get('/event/{event_id}/users/reserve/{user_id}', [
    'as' => 'event_user_reserve',
    'uses' => 'EventController@user_reserve',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);
Route::get('/event/{event_id}/users/delete/{user_id}', [
    'as' => 'event_user_delete',
    'uses' => 'EventController@user_delete',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);

Route::get('/event/edit/{event_id}', [
    'as' => 'event_edit',
    'uses' => 'EventController@edit',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);
Route::post('/event/update/{event_id}', [
    'as' => 'event_update',
    'uses' => 'EventController@update',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);

Route::get('/event/close/{event_id}', [
    'as' => 'event_close',
    'uses' => 'EventController@close',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);

Route::get('/event/delete/{event_id}', [
    'as' => 'event_delete',
    'uses' => 'EventController@delete',
    'middleware' => 'roles',
    'roles' => ['Admin']
]);

// Assignment Controller
Route::get('working_time', 'WorkingTimeController@index')->name('working_time');
Route::get('working_time/create', 'WorkingTimeController@create')->name('working_time_create');
Route::post('working_time/store', 'WorkingTimeController@store')->name('working_time_store');
Route::get('working_time/{workingTime}/edit', 'WorkingTimeController@edit')->name('working_time_edit');
Route::post('working_time/{workingTime}/update', 'WorkingTimeController@update')->name('working_time_update');
Route::get('working_time/{workingTime}/delete', 'WorkingTimeController@delete')->name('working_time_delete');

// Document Controller

Route::group(['prefix' => '{document_type}'], function(){
    Route::get('/list/{user_id?}', 'DocumentController@index')->name('document_list');

    Route::get('/create', 'DocumentController@create')->name('document_create');
    Route::post('/store', 'DocumentController@store')->name('document_store');

    Route::get('/archive/{document_id}', 'DocumentController@archive')->name('document_archive');
    Route::get('/archived', 'DocumentController@archived')->name('document_archived');
    Route::get('/un_archive/{document_id}', 'DocumentController@unArchive')->name('document_un_archive');

    Route::get('/ajax/{document_id}', 'DocumentController@ajax')->name('document_ajax');
    Route::post('/update_files/{document_id}', 'DocumentController@updateFiles')->name('document_update_files');
    Route::get('/delete_file/{document_id}/{file_name}', 'DocumentController@deleteFile')->name('document_delete_file');

    Route::get('/edit/{document_id}', 'DocumentController@edit')->name('document_edit');
    Route::post('/update/{document_id}', 'DocumentController@update')->name('document_update');

    Route::get('/delete/{document_id}', 'DocumentController@delete')->name('document_delete');
});