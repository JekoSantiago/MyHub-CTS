<?php

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//PageController
Route::get('/','AuthController@index')->name('index');
Route::get('/denom','PageController@cts')->name('cts');
Route::get('/monitoring','PageController@monitoring')->name('monitoring');
Route::get('/compliance','PageController@compliance')->name('compliance');
Route::get('/monitoring-tally/{ctsID}','PageController@tallySheet');
Route::get('/logout' , 'AuthController@logout')->name('logout');
Route::get('/audit', 'PageController@audit')->name('audit');


//CTS
Route::post('/cts-insert','CtsController@insertCTS');
Route::post('/cts-get','CtsController@getCTS');
Route::post('/denom-insert','CtsController@insertDenom');
Route::get('/denom-pickup/{id}','CtsController@getPickupType');

//Monitoring
Route::post('/monitoring-get','MonitoringController@getMCTS');
Route::post('/tally-get','MonitoringController@getTallySheet');
Route::get('/cts-print/{ctsNo}/{shift}','ReportController@exportCTS');
Route::get('/cts-print2/{ctsNo}/{shift}','ReportController@exportCTS');



// Compliance
Route::post('/compliance-get','ComplianceController@getCompliance');
Route::get('/compliance-dl/{params}','ReportController@exportCompliance');

//Audit
Route::post('/audit-get','AuditController@getAuditDT');
Route::get('/audit-dl/{params}','ReportController@exportAudit');
Route::post('/image-get','AuditController@getImage');
Route::get('/status-get','OptionsController@getStatus');
Route::post('/status-insert','AuditController@insertRemStatus');

//Options
Route::post('/am-get','OptionsController@getAM');
Route::post('/ac-get','OptionsController@getAC');
Route::post('/storeac-get','OptionsController@getStoreAC');

//Error
Route::get('/expired','AuthController@expired');





