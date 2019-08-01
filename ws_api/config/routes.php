<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'Routes';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['api/home'] = 'v1/home/home';