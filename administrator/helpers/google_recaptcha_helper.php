<?php
if (!function_exists('validateCapcha')){
	function validateCapcha($key){
		if(!empty($key)){
			$postdata = http_build_query(
	            array(
	                'secret'   => GOOGLE_CAPTCHA_SECRET_KEY,
	                'response' => $key,
	                'remoteip' => $_SERVER['REMOTE_ADDR']
	            )
	        );
	 
	        $options = array('http' =>
	            array(
	                'method'  => 'POST',
	                'header'  => 'Content-type: application/x-www-form-urlencoded',
	                'content' => $postdata
	            )
	        );
	 
	        $context = stream_context_create($options);
	        $response  = json_decode(file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context));
			
			print_r($response);
			if(!$response->success)
				return false;
		}else
			return false;
		return true;
	}
}
if (!function_exists('getCapcha')){
	function getCaptcha($callback, $button_text, $classes = ''){
		return '<div class="g-recaptcha" data-sitekey="'. GOOGLE_CAPTCHA_SITE_KEY .'" data-callback="recaptchaSubmit" data-size="invisible"></div>
		  <textarea name="g-recaptcha-response" class="d-none"></textarea>
          <button type="button" class="' .$classes. '" data-form-id="'. $callback .'">'. $button_text .'</button>';	
	}

	function getCaptchaJS(){ 
		$js = new stdClass(); 
		$js->file = array('https://www.google.com/recaptcha/api.js?hl=hu', 'recaptcha_init.js');
		$js->script = '<script type="text/javascript">var recaptcha_site_key = \''. GOOGLE_CAPTCHA_SITE_KEY .'\';</script>';
		return $js; 
	}
}
?>