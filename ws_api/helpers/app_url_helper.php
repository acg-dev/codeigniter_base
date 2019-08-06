<?php 

if(!function_exists('root_url')){
	function root_url( $path = '') {
		$ci = &get_instance();
		$uri_prefix = $ci->config->item('application_uri_prefix');
		$base_url = base_url();
		if( !empty($uri_prefix) ) {
			$base_url = str_replace(["{$uri_prefix}/"], '', base_url());
		}
		return $base_url.$path;
	}
}
/*
	parameters:
		-uri
		-get paramters
		-lang
 */
if(!function_exists('url')){
	function url($uri, $params = array() , $lang = '') {
		$ci = &get_instance();
		$url = $uri;

		if( true === is_array($params) && 0 < count($params) ) {
			$params_str_arr = array();
			foreach( $params as $key => $param ) {
				$params_str_arr[] = "{$key}={$param}";
			}
			$params_str = implode('&', $params_str_arr);
			$url .= '?' . $params_str;
		}
		if( true === $ci->config->item('application_use_multilang') && '' === $lang ) {
			$lang = $ci->current_language['key'];
		}
		return root_url("$url");
	}
}

if(!function_exists('action_url')){
	function action_url( $action , $params = array() , $qs = array() , $lang = '' ) {
		$ci = &get_instance();
			
		if( true === $ci->config->item('application_use_multilang') ) {
			$uri = Route::get($action, ( !empty($lang) ) ? $lang : $ci->current_language['key'] );
		}
		else {
			$uri = Route::get($action, $ci->current_language['key'] );
		}
		if( true === is_array($params) ) {
			foreach( $params as $key => $val ) {
				$uri = str_replace(":{$key}", $val, $uri);
			}
		}
		return url($uri , $qs , $lang );
	}
}

if(!function_exists('action_redirect')){
	function action_redirect( $action , $params = array() , $qs = array() , $lang = '' ) {
		$ci = &get_instance();
		redirect( str_replace($ci->config->item('base_url'), '', action_url($action, $params, $qs, $lang)) );
	}
}