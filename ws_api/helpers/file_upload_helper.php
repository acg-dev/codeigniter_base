<?php
if (!function_exists('uploadFile')){
	function uploadFile($input_name, $path, $allowed_types = 'jpg|png|jpeg|pdf|mp4|mpeg|mpg|mov|3gp|avi', $max_size = 10240){
		$CI = & get_instance();
		$path .= '/';
		$config['upload_path'] = UPLOAD_DOCUMENTS_ROOT . $path;
		$config['encrypt_name'] = TRUE;
		
		if(!is_dir($config['upload_path']))
			mkdir($config['upload_path'], 0777, true);
		$config['allowed_types'] = $allowed_types;
		$config['max_size']	= $max_size;
		$CI->load->library('upload', $config);
		$CI->upload->initialize($config);
		
		$files = array();
		if(!empty($_FILES) && array_key_exists($input_name, $_FILES)){
			if ($CI->upload->do_upload($input_name)){
				$file = $CI->upload->data();
				$file['file_web_path'] = $path;
				$file['file_url'] = '/' . $path . $file['file_name'];

				return (object) $file;

			}else{
				return false;
			}
		}
	}	
}

if (!function_exists('convert_filename')){
	function convert_filename($str) {
	    $str = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
	    $str = preg_replace("/[^a-zA-Z0-9\/_\.\-]/", '', $str);
	    $str = strtolower(trim($str, '-'));

	    return $str;
	}
}

if (!function_exists('download_file')){
	function download_file($file, $orig_name, $file_type){
	if( !file_exists($file) ) die("Fájl nem található");
		header('Content-Type: ' . $file_type);
		header('Content-Disposition: inline; filename="' . $orig_name . '"');
		// header('Content-Disposition: attachment; filename="' . $orig_name . '"');
		header("Content-Length: " . filesize($file));
		readfile($file);
    }
}
?>