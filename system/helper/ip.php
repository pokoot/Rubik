<?php  if ( !defined("BASE_PATH")) exit( "No direct script access allowed" );


/**
 * Get the real ip address
 *
 * @access public
 * @return string
 */
if( !function_exists('ip_get') ){
    function ip_get(){

        //check ip from share internet
        if( !empty($_SERVER['HTTP_CLIENT_IP'] ) ){
            $ip = $_SERVER['HTTP_CLIENT_IP'];

        //to check ip is pass from proxy
        }else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        // force ip for localhost
        if( $ip == "::1" ){
            $ip = "127.0.0.1";
        }

        return $ip;
    }
}




/**
 * Can access the site based on $IP - inc.ip.php
 *
 * @access public
 * @return boolean
 */
if( !function_exists('ip_access') ){
    function ip_access(){
        GLOBAL $IP;
        for( $i=0, $cnt = count( $IP ) ; $i < $cnt; $i++){
            $ipregex = preg_replace("/\./", "\.", $IP[$i]);
            $ipregex = preg_replace("/\*/", ".*", $ipregex);

            if(preg_match('/^'.$ipregex.'/', ip_get() ) ){
                return true;
            }
        }
        return false;
    }
}


?>
