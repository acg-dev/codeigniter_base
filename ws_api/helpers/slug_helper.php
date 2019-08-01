<?php

function slug($str, $replace = array(), $delimiter = '-') {
    
    $replace = array_merge($replace,array(
	'á'=>'a',
	'é'=>'e',
	'í'=>'i',
	'ó'=>'o',
	'ö'=>'o',
	'ő'=>'o',
	'ú'=>'u',
	'ü'=>'u',
	'ű'=>'u',
    ));
    
    $str = mb_strtolower($str);
    foreach( $replace as $from_chr => $to_chr ) {
	$str = str_replace($from_chr,$to_chr,$str);
    }
    
    $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
    $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
    $clean = strtolower(trim($clean, '-'));
    $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
    
    return $clean;
}

function createalias($string){
    $pattern = (object) array(
                            'search' => array('á','Á','é','É','í','Í','ó','Ó','ö','Ö','ő','Ő','ú','Ú','ü','Ü','ű','Ű','/','\\','?','.','_','*','+','"','\'','%','!','=','(',')','[',']','<','>','{','}','&','@','#','|',' ',','),
                            'replace' => array('a','a','e','e','i','i','o','o','o','o','o','o','u','u','u','u','u','u','_','_' ,'' ,'' ,'_','','','','' ,'','' ,'','','','','','','','','','','','','','_','')
						);
    return trim(strtoupper(str_replace($pattern->search, $pattern->replace, $string)));
}