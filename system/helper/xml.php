<?php  if ( !defined("BASE_PATH")) exit( "No direct script access allowed" );


/**
 * * Convert Reserved XML characters to Entities
 * 
 * @access public
 * @param mixed $str 
 * @param mixed $protect_all 
 * @return void
 */
if( !function_exists('xml_convert')){
    
    function xml_convert($str, $protect_all = false){
		$temp = '__TEMP_AMPERSANDS__';

		// Replace entities to temporary markers so that
		// ampersands won't get messed up
		$str = preg_replace("/&#(\d+);/", "$temp\\1;", $str);

		if($protect_all === true){
			$str = preg_replace("/&(\w+);/",  "$temp\\1;", $str);
		}

		$str = str_replace( array("&","<",">","\"", "'", "-"),
							array("&amp;", "&lt;", "&gt;", "&quot;", "&apos;", "&#45;"),
							$str);

		// Decode the temp markers back to entities
		$str = preg_replace("/$temp(\d+);/","&#\\1;",$str);

		if($protect_all === true){
			$str = preg_replace("/$temp(\w+);/","&\\1;", $str);
		}

		return $str;
	}
}



?>