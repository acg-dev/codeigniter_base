<?php

if (!function_exists('convert_date')){
	function convert_date($date){
		$ci = &get_instance();

		if(is_numeric($date)){
			$date = date('Y-m-d H:i:s', $date);
		}
		preg_match('/((?P<year>\d{4}).{1,3}(?P<month>\d{2}).{1,3}(?P<day>\d{2}).{1,3}(?P<hour>\d{2}).{1,3}(?P<minute>\d{2}).*)/',  $date, $m);
		if(count($m) <= 0)
			preg_match('/((?P<year>\d{4}).{1,3}(?P<month>\d{2}).{1,3}(?P<day>\d{2}).*)/',  $date, $m);

		$date = (!empty($m['year'])? $m['year'] : '1970') .'-'. (!empty($m['month'])? $m['month'] : '01') .'-'. (!empty($m['day'])? $m['day'] : '01') . ' ' . (!empty($m['hour'])? $m['hour'] : '00') . ':' . (!empty($m['minute'])? $m['minute'] : '00') . ':00';
		
		$data = (object) array(
							'original' => $date, 
							'date' => date($ci->current_language['date_format_full'], strtotime($date)), 
							'time' => date($ci->current_language['time_format_short'], strtotime($date)), 
							'long_time' => date($ci->current_language['time_format_long'], strtotime($date)), 
							'datetime' => date($ci->current_language['datetime_format_full'], strtotime($date)), 
							'day_string' => '', 
							'to_string' => '', 
							'day_name'=> $ci->current_language['day_name'][date('N', strtotime($date)) - 1], 
							'month_name' => $ci->current_language['month_name'][date('m', strtotime($date)) - 1], 
							'month_short_name' => $ci->current_language['month_short_name'][date('m', strtotime($date)) - 1], 
							'day_of_week' => date('N', strtotime($date)), 
							'Y' => date('Y', strtotime($date)), 
							'm' => date('m', strtotime($date)), 
							'n' => date('n', strtotime($date)), 
							'd' => date('d', strtotime($date)), 
							'D' => date('d', strtotime($date)), 
							'j' => date('j', strtotime($date)), 
							'H' => date('H', strtotime($date)), 
							'i' => date('i', strtotime($date)), 
							's' => date('s', strtotime($date))
						);

		$data->to_string = str_replace(array('{Y}', '{m}', '{d}'), array($data->Y, $data->month_name, $data->d), $ci->current_language['date_format_string']);
		
		if(strtotime($date) >= strtotime(date('Y-m-d 00:00:00')) && strtotime($date) <= strtotime(date('Y-m-d 23:59:59')))
			$data->day_string = $ci->current_language['day_string']['today'];
		elseif(strtotime($date) >= (strtotime(date('Y-m-d 00:00:00')) - (60 * 60 * 24)) && strtotime($date) <= (strtotime(date('Y-m-d 23:59:59')) - (60 * 60 * 24)))
			$data->day_string = $ci->current_language['day_string']['yesterday'];
		elseif(strtotime($date) >= (strtotime(date('Y-m-d 00:00:00')) - (60 * 60 * 24 *2)) && strtotime($date) <= (strtotime(date('Y-m-d 23:59:59')) - (60 * 60 * 24 *2)))
			$data->day_string = $ci->current_language['day_string']['before_yesterday'];
		elseif(strtotime($date) < strtotime(date('Y-01-01 00:00:00')) || strtotime($date) > strtotime(date('Y-12-31 23:59:59')))
			$data->day_string = $data->Y .' '. $data->month_name .' '. $data->d .'.';
		elseif(strtotime($date) < strtotime(date('Y-m-'. (date('j', strtotime($date)) - $data->day_of_week) .' 00:00:00')) || strtotime($date) > date('Y-m-'. (date('j', strtotime($date)) + (7 - $data->day_of_week)) .' 00:00:00'))
			$data->day_string = $data->month_name .' '. $data->d .'.';
		elseif(strtotime($date) >= (strtotime(date('Y-m-d 00:00:00')) + (60 * 60 * 24)) && strtotime($date) <= (strtotime(date('Y-m-d 23:59:59')) + (60 * 60 * 24)))
			$data->day_string = $ci->current_language['day_string']['tomorrow'];
		elseif(strtotime($date) >= (strtotime(date('Y-m-d 00:00:00')) + (60 * 60 * 24 *2)) && strtotime($date) <= (strtotime(date('Y-m-d 23:59:59')) + (60 * 60 * 24 *2)))
			$data->day_string = $ci->current_language['day_string']['after_tomorrow'];
		else
			$data->day_string = $day_name[date('N', strtotime($date)) - 1];
		
		return $data;
	}
}

if (!function_exists('convert_float_hour')){
	function convert_float_hour($time){
		$minute = round(($time - floor($time)) * 60); 
      	$hour = floor($time);
      	if($hour <= 0){
        	return $minute .' perc';
      	}else{
      		if($minute == 0){
      			return $hour .' óra';
      		}else{
      			return $hour .' óra '. $minute .' perc';
      		}
      	}
        return $time;
	}
}