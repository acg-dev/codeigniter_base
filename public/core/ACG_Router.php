<?php defined('BASEPATH') OR exit('No direct script access allowed');
	
class ACG_Router extends CI_Router{}

class Route{
	private static $reverse_route = array();
	public static $global_config;

    public static function loadConfig(){
		if (file_exists(APPPATH.'config/global.php')){
			include(APPPATH.'config/global.php');
			self::$global_config = $config;
		}
    }

	private static function add( $method, $action , $route , $lang ) {

		if( empty(self::$reverse_route[$method]) ) {
			self::$reverse_route[$method] = [];
		}
		if( empty(self::$reverse_route[$method][$lang]) ) {
			self::$reverse_route[$method][$lang] = [];
		}
		self::$reverse_route[$method][$lang][$action] = $route;
	}

	public static function get( $action , $lang, $method = 'GET' ) {
		if(array_key_exists($method, self::$reverse_route) && array_key_exists($lang, self::$reverse_route[$method]) && array_key_exists($action, self::$reverse_route[$method][$lang])){
			return self::$reverse_route[$method][$lang][$action]['route'];
		}
		return '';
	}

	public static function get_all() {
		return self::$reverse_route;
	}

	public static function get_ci_all() {
		$routes = array();
		
		foreach( self::$reverse_route as $method => $methods ) {
			foreach( $methods as $lang => $actions ) {
				foreach( $actions as $action => $row) {
					$routes[$row['route']][$method] = $action . self::get_param_string($row['params']);
				}
			}
		}

		return $routes;
	}

	private static function get_param_string($params) {
		$str = [];
		if(count($params) > 0){
			for ($i = 1; $i <= count($params); $i++) { 
				$str[] = "\${$i}";
			}
		}

		return (count($str) > 0 ? '/' : '') . implode('/', $str);
	}

	public static function set( $method , $route_str , $params , $action , $lang = '' ) {

		if(self::$global_config['application_language_storage'] == 'URL'){
			if( (is_string($lang) && empty($lang)) || (is_array($lang) && 0 == count($lang) ) ) {
				$lang = self::$global_config['application_default_language_key'];
			}elseif($lang == 'ALL'){
				$lang = array_keys(self::$global_config['languages']);
			}
			
			if( !is_array($lang) ) {
				$lang = [$lang];
			}

			foreach( $lang as $l ) {
				if(array_key_exists($l, self::$global_config['languages'])){
					$a = $action;
					$r_str = $route_str;
					if( self::$global_config['application_use_multilang'] ) {
						$r_str = (
							(0 == strlen($r_str)) ? $l : "$l/"
						).$r_str;
					}
					if( !empty(self::$global_config['application_uri_prefix']) ) {
						$r_str = self::$global_config['application_uri_prefix'] . $r_str;
					}
					
					foreach( $params as $key => $param ) {
						$r_str = str_replace(":$key", $param, $r_str);
					}
					
					self::add($method, $a , array('route' => $r_str, 'params' => $params) , $l );
				}
			}
		}elseif(self::$global_config['application_language_storage'] == 'SESSION'){
			if(!empty($route_str)){
				$a = $action;
				$r_str = $route_str;
				
				if( !empty(self::$global_config['application_uri_prefix']) ) {
					$r_str = (
						(0 == strlen($r_str)) ? self::$global_config['application_uri_prefix'] : "{" . self::$global_config['application_uri_prefix'] . "}/"
					).$r_str;
				}
				
				foreach( $params as $key => $param ) {
					$r_str = str_replace(":$key", $param, $r_str);
				}
				
				self::add($method, $a, array('route' => $r_str, 'params' => $params), 'default');
			}
		}
	}
}

?>