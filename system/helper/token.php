<?php  if ( !defined("BASE_PATH")) exit( "No direct script access allowed" );

/**
 * Create a 32 bit token string with n'th day expiration 
 * 
 * @access public
 * @param float $day 
 * @param float $hour 
 * @param float $minute 
 * @return void
*/
if( !function_exists('token_create')){
         
    function token_create( $day = 1 , $hour = 0 , $minute = 0 ){

        // n'th day * 24 hours * 60 minutes * 60 seconds         

        $temp_day       = 0;
        $temp_hour      = 0;
        $temp_minute    = 0; 

        if( $day != 0 ){
            $temp_day = $day * 24 * 60 * 60 ;
        }

        if( $hour != 0 ){
            $temp_hour = $hour * 60 * 60;
        }

        if( $minute != 0 ){        
            $temp_minute = $minute * 60;
        }
        
        $time = time() + $temp_day + $temp_hour + $temp_minute;

        //print "<Br/> temp day = " . $temp_day;
        //print "<Br/> temp hour = " . $temp_hour;
        //print "<Br/> temp minute = " . $temp_minute;
        //print "<br/> current time = " . time();
        //print "<Br/> sum time = $time ";

        $random = random_string( "alnum" , 7 );
        //print "<br/> random str = $random || " . strlen( $random ) ;


        $hex =  dechex( $time );
        //print "<Br/> hex = " . $hex . " || " . strlen( $hex );

        $pos = rand(0 , 8 );    
        $char = chr( 65 + $pos);
        //print "<Br/> char = $char || " . strlen( $char ) ;

        $str = $random . $hex . $char ;


        //print "<br/> random + hex + char = "  . $str . " || " . strlen( $str ) ;

        $encrypted = substr( md5( $str . SITE_KEY ), $pos, 16 );

        //print "<Br/> encrypted = $encrypted || " . strlen( $encrypted );
         
        return $random . $hex . $char . $encrypted;
    }
}




/**
 * Validates a token within a day ( Depends on checking flag )
 * Return true if valid.
 *
 * @access	public
 * @param	string
 * @param bool $expiry_check 
 * @return	boolean
 */
if( !function_exists( 'token_validate' ) ){
     
    function token_validate( $str , $expiry_check = true ) {

        if( !$str ){
            return false;
        }

        $time = hexdec( substr($str, 7, 8) );

        if( $expiry_check && $time <= time() ){
            return false;        
        }

        $random = substr($str, 0, 16);

        return $str == $random . substr(md5($random . SITE_KEY ), ord($str[15])-65,  16 );
    }
}


?>
