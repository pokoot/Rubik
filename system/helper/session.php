<?php  if ( !defined("BASE_PATH")) exit( "No direct script access allowed" );

/**
 * Get session
 *
 * @access public
 * @param mixed $key
 * @param mixed $value
 * @return void
 */
if( !function_exists('session_get')){
    function session_get( $key , $default = "" ){
        if( array_key_exists( SESSION_PREFIX . $key , $_SESSION ) ){
            return decrypt( $_SESSION[ SESSION_PREFIX . $key ] );
        }else{
            //session_set( $key , $default );
            return $default;
        }
    }
}




/**
 * Set Session
 *
 * @access public
 * @param mixed $key
 * @param mixed $value
 * @return void
 */
if( !function_exists('session_set')){
    function session_set( $key , $value ){
        $_SESSION[ SESSION_PREFIX . $key ] = encrypt( $value );
    }
}



/**
 * Erase all session
 *
 * @access public
 * @return void
 */
if( !function_exists('session_erase')){

    function session_erase(){
        $v = array();
        foreach( $_SESSION AS $x => $y){
            $v[] = $x;
        }
        foreach($v as $x){
            $temp = explode( "_" , $x );

            // exclude the underscore
            if( $temp[0] == substr( SESSION_PREFIX , 0 , -1) ){

                debug( "session erase = " . $x );

                unset( $_SESSION[$x] );
            }
        }



    }
}









?>
