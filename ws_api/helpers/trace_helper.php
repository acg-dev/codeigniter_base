<?php
	function trace( $variable , $exit = true , $method = 'print_r' ) { 
		echo '<pre>'; 
		$method( $variable ); 
		echo '</pre>'; 
		if( true === $exit ) { 
			exit; 
		}
	}