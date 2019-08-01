<?php 
if(!function_exists('app_url')){
	function app_url($app = ''){
		if(strtolower($app) == 'api'){
			return base_url('api/');
		}else{
			return base_url($app);
		}
	}
}