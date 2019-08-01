<?php

if (!function_exists('convert_date')){
	function convert_date($date){
		if(is_numeric($date)){
			$date = date('Y-m-d H:i:s', $date);
		}
		preg_match('/((?P<year>\d{4}).{1,3}(?P<month>\d{2}).{1,3}(?P<day>\d{2}).{1,3}(?P<hour>\d{2}).{1,3}(?P<minute>\d{2}).*)/',  $date, $m);
		if(count($m) <= 0)
			preg_match('/((?P<year>\d{4}).{1,3}(?P<month>\d{2}).{1,3}(?P<day>\d{2}).*)/',  $date, $m);

		$date = (!empty($m['year'])? $m['year'] : '1970') .'-'. (!empty($m['month'])? $m['month'] : '01') .'-'. (!empty($m['day'])? $m['day'] : '01') . ' ' . (!empty($m['hour'])? $m['hour'] : '00') . ':' . (!empty($m['minute'])? $m['minute'] : '00') . ':00';
		$day_name = array('hétfő', 'kedd', 'szerda', 'csütörtök', 'péntek', 'szombat', 'vasárnap');
		$month_name = array('január', 'február', 'március', 'április', 'május', 'június', 'július', 'augusztus', 'szeptember', 'október', 'november', 'december');
		$month_short_name = array('jan', 'febr', 'márc', 'ápr', 'máj', 'júns', 'júl', 'aug', 'szept', 'okt', 'nov', 'dec');
		$data = (object) array(
							'original' => $date, 
							'date' => date('Y-m-d', strtotime($date)), 
							'date_hu' => date('Y. m. d.', strtotime($date)), 
							'time' => date('H:i', strtotime($date)), 
							'date_time' => date('Y-m-d H:i', strtotime($date)), 
							'day_string' => '', 
							'to_string' => '', 
							'day_name'=> $day_name[date('N', strtotime($date)) - 1], 
							'month_name' => $month_name[date('m', strtotime($date)) - 1], 
							'month_short_name' => $month_short_name[date('m', strtotime($date)) - 1], 
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

		$data->to_string = $data->Y .' '. $data->month_name .' '. $data->d;
		
		if(strtotime($date) >= strtotime(date('Y-m-d 00:00:00')) && strtotime($date) <= strtotime(date('Y-m-d 23:59:59')))
			$data->day_string = 'ma';
		elseif(strtotime($date) >= (strtotime(date('Y-m-d 00:00:00')) - (60 * 60 * 24)) && strtotime($date) <= (strtotime(date('Y-m-d 23:59:59')) - (60 * 60 * 24)))
			$data->day_string = 'tegnap';
		elseif(strtotime($date) >= (strtotime(date('Y-m-d 00:00:00')) - (60 * 60 * 24 *2)) && strtotime($date) <= (strtotime(date('Y-m-d 23:59:59')) - (60 * 60 * 24 *2)))
			$data->day_string = 'tegnap előtt';
		elseif(strtotime($date) < strtotime(date('Y-01-01 00:00:00')) || strtotime($date) > strtotime(date('Y-12-31 23:59:59')))
			$data->day_string = $data->Y .' '. $data->month_name .' '. $data->d .'.';
		elseif(strtotime($date) < strtotime(date('Y-m-'. (date('j', strtotime($date)) - $data->day_of_week) .' 00:00:00')) || strtotime($date) > date('Y-m-'. (date('j', strtotime($date)) + (7 - $data->day_of_week)) .' 00:00:00'))
			$data->day_string = $data->month_name .' '. $data->d .'.';
		elseif(strtotime($date) >= (strtotime(date('Y-m-d 00:00:00')) + (60 * 60 * 24)) && strtotime($date) <= (strtotime(date('Y-m-d 23:59:59')) + (60 * 60 * 24)))
			$data->day_string = 'holnap';
		elseif(strtotime($date) >= (strtotime(date('Y-m-d 00:00:00')) + (60 * 60 * 24 *2)) && strtotime($date) <= (strtotime(date('Y-m-d 23:59:59')) + (60 * 60 * 24 *2)))
			$data->day_string = 'holnap után';
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