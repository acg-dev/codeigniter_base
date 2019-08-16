<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function route_hook() {
	if (file_exists(APPPATH.'config/config.php') && file_exists(APPPATH.'config/global.php')){
		include(APPPATH.'config/config.php');
		include(APPPATH.'config/global.php');
	
		if($config['application_use_multilang'] && $config['application_language_storage'] == 'URL' && !empty($config['application_default_language_key'])){
			$found = false;
			foreach (array_keys($config['languages']) as $lang) {
				if(preg_match("/\/{$lang}\//", $_SERVER['REQUEST_URI'] . '/')){
					$found = true;
				}
			}

			if(!$found){
				$uri = $config['base_url'] . $config['application_default_language_key'] . '/';

				$request_uri = explode('?', $_SERVER['REQUEST_URI']);

				if(array_key_exists(0, $request_uri)){
					$uri .= str_replace('/'. $config['base_uri'] . '/', '', $request_uri[0]);
				}
				if(array_key_exists(1, $request_uri)){
					$uri .= '?' . $request_uri[1];
				}

				header('location: ' . $uri);
			}
		}
	}
}