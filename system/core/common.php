<?php  

if ( !defined("BASE_PATH")) exit( "No direct script access allowed." );  

/**
 * Check php version
 * 
 * @access public
 * @param string $version 
 * @return void
 */
if( !function_exists("is_php")){
   
    function is_php( $version = '5.0.0' ){
            
		static $_is_php;
        //print "<Br/> is_php = $_is_php ";

		$version = (string) $version;

		if ( !isset($_is_php[$version])){
			$_is_php[$version] = (version_compare(PHP_VERSION, $version) < 0) ? FALSE : TRUE;
		}

		return $_is_php[$version];
    }
} 
    

/**
 * Translate the files
 * 
 * @access protected
 * @param mixed $msg 
 * @return void
 */
if( !function_exists("__")){
    
    function __( $constant , $print = true ){

        GLOBAL $TRANSLATION;


        $value = ( $constant == '' OR !isset( $TRANSLATION[$constant] ) ) ? 
            FALSE : $TRANSLATION[ $constant ];

        if ($value === FALSE){

            if( $print == true ){
                print $constant;
            }else{
                return $constant;
            }
        }

        if( $print == true ){
            print $value;
        }else{
            return $value;
        }
    }

}
?>
