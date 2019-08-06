<?php

function currency( $value , $currency_key = '' ) {
	//trace($value);
	$ci = &get_instance();
	if( false === is_string($currency_key) || true === empty($currency_key) ) { $currency_key = $ci->currency['key']; }
	if( empty($value) ) { $value = 0; }
	$cur = $ci->config->item('currencies')[$currency_key];
	$value = str_replace(' ','',$value);
	$value = str_replace(',','.',$value);
	return str_replace(
		array(':value:',':label:'),
		array(
			number_format(
				$value,
				$cur['number_format']['decimals'],
				$cur['number_format']['decimal_delimiter'],
				$cur['number_format']['thousend_delimiter']
			),
			$cur['label']
		),
		$cur['format']
	);
}