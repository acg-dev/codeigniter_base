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

Route::set('PUT' ,'cookie' , [], 'v1/cookie/index');
Route::set('GET' ,'home' , [], 'v1/home/home');

/*ROUTE end*/

$route += Route::get_ci_all();
