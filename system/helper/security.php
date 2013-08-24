<?php  if ( !defined("BASE_PATH")) exit( "No direct script access allowed" ); 


/**
 * Cleans a string for sql queries
 * 
 * @access public
 * @param mixed $str 
 * @param mixed $encode_ent 
 * @return void
 */
if( !function_exists('clean')){
    function clean( $str , $encode_ent = false ){

        
        if( is_array( $str )) {
            return $str;
        }

        $str = @trim( $str );

        if( $encode_ent ){
            $str = htmlentities($str);
        }
        if( version_compare( phpversion() ,'4.3.0') >= 0 ){
            
            if(get_magic_quotes_gpc()){                
                $str = stripslashes($str);                
            }

            if( @mysql_ping() ){                
                $str = mysql_real_escape_string($str);                
            }else{                
                $str = addslashes($str);                
            }

        }else{

            if( !get_magic_quotes_gpc() ){
                $str = addslashes($str);
            }
        }

        return $str;
    }

}


 
 

/**
 * XSS Filtering
 *
 * @access	public
 * @param	string
 * @param	bool	whether or not the content is an image file
 * @return	string
 */
/*
if( !function_exists('test')){
    function xss_clean($str, $is_image = false){
        $security = new Security();
		return $security->xss_clean($str, $is_image);
	}
}
*

/**
 * Sanitize Filename
 *
 * @access	public
 * @param	string
 * @return	string
 */
if( !function_exists('sanitize_filename')){
	function sanitize_filename($filename , $relative_path = false  ){		
		return Security::$instance->sanitize_filename($filename , $relative_path );
	}
}


/**
 * Hash encode a string
 *
 * @access	public
 * @param	string
 * @return	string
 */
if( !function_exists('do_hash')){
	function do_hash($str, $type = 'SHA1'){
		if($type == 'SHA1'){
			return sha1($str);
		}else{
			return md5($str);
		}
	}
}


/**
 * Strip Image Tags
 *
 * @access	public
 * @param	string
 * @return	string
 */
if( !function_exists('strip_image_tags')){
	function strip_image_tags($str){
		$str = preg_replace("#<img\s+.*?src\s*=\s*[\"'](.+?)[\"'].*?\>#", "\\1", $str);
		$str = preg_replace("#<img\s+.*?src\s*=\s*(.+?).*?\>#", "\\1", $str);

		return $str;
	}
}




/**
 * Remove Invisible Characters
 *
 * This prevents sandwiching null characters
 * between ascii characters, like Java\0script.
 *
 * @access	public
 * @param	string
 * @return	string
 */
if( !function_exists('remove_invisible_characters')){
	function remove_invisible_characters($str, $url_encoded = true){
		$non_displayables = array();
		
		// every control character except newline (dec 10)
		// carriage return (dec 13), and horizontal tab (dec 09)
		
		if($url_encoded){
			$non_displayables[] = '/%0[0-8bcef]/';	// url encoded 00-08, 11, 12, 14, 15
			$non_displayables[] = '/%1[0-9a-f]/';	// url encoded 16-31
		}
		
		$non_displayables[] = '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S';	// 00-08, 11, 12, 14-31, 127

		do{
			$str = preg_replace($non_displayables, '', $str, -1, $count);
		}while ($count);

		return $str;
	}
}





/**
 * Convert PHP tags to entities
 *
 * @access	public
 * @param	string
 * @return	string
 */
if( !function_exists('encode_php_tags')){
	function encode_php_tags($str){
		return str_replace(array('<?php', '<?PHP', '<?', '?>' ),  array( '&lt;?php', '&lt;?PHP', '&lt;?', '?&gt;'), $str);
	}
}

?>
