<?php 
if(!function_exists('get_image_size')){
	function get_image_size($file, $size_type = 'all'){
		if(file_exists(FCPATH . $file)){
			list($width, $height) = getimagesize(FCPATH . $file);
			if($size_type == 'height')
				return $height;
			elseif($size_type == 'width')
				return $width;
			else
				return (object) array('width' => $width, 'height' => $height);
		}
		return 0;
	}
}

if (!function_exists('svg')){
	function svg($file, $path = ''){
		if(!empty($path) && !empty($file) && file_exists(FCPATH. $path . $file .'.svg'))
			return file_get_contents ( FCPATH. $path . $file .'.svg') ;
		elseif(!empty($file) && file_exists(FCPATH."assets/default/images/svg/". $file .'.svg')){
			return file_get_contents ( FCPATH."assets/default/images/svg/".$file .'.svg') ;
		}
		
		return '';
	}
}