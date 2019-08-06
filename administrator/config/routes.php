<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Route::loadConfig();

$route['default_controller'] = 'Authentication';
$route['404_override'] = 'routes/redirect_404';
$route['404'] = 'routes/redirect_404';
$route['translate_uri_dashes'] = FALSE;

/*
 * ROUTE start
 * parameters:
 *     - method: (GET, POST, PUT, DELETE)
 *     - uri (parameters :param1/:param2/:param3...)
 *     - url parameters: (array) 
 *           - key: uri parameters (:param1/:param2/:param3...)
 *           - value: parameters type ((:num), (:any), (regexp))
 *     - action:
 *     		- directories (optional)
 *     		- controller
 *     		- function
 *     - languages: (optional) 
 *     		- empty (use default language)
 *     		- ALL (generate all language route)
 *     		- language list (array)
 * 
*/

/* use, if application_language_storage is SESSION */
Route::set('GET' ,'language/:lang' , ['lang' => '(:any)'], 'routes/change_language', 'ALL');


Route::set('GET' ,'/' , [], 'Authentication/index', 'ALL');
Route::set('GET' ,'login' , [], 'Authentication/index', 'ALL');
Route::set('GET' ,'dashboard' , [], 'dashboard/index', 'ALL');
Route::set('POST' ,'authentication/sign-in' , [], 'Authentication/sign_in', 'ALL');
Route::set('GET' ,'authentication/sign-out' , [], 'Authentication/sign_out', 'ALL');

/*ROUTE end*/

$route += Route::get_ci_all();


// echo "<pre>";
// print_r($route);
// echo "</pre>";