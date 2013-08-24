<?php  if ( !defined("BASE_PATH")) exit( "No direct script access allowed" );



/**
 * NOTE:
 *      true - for valid ( pass validation )
 *      false - invalid / error
 */





/**
 *  
 * 
 * @access public
 * @param mixed $email 
 * @return void
 */
if( !function_exists('validate_empty') ){
    
    function validate_empty( $data = "" ){
        
        $data = trim( $data );

        if( empty( $data ) ){            
            return true;
        }
		return false;
	}
}


/*
 * Validate email address
 *
 * @access	public
 * @return	bool
 */
if( !function_exists('validate_email') ){
    function validate_email( $email ){
        //$pattern = '/^([a-zA-Z0-9])+([\.a-zA-Z0-9_-])*@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-]+)+/';
        $pattern = "/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix";
		return ( preg_match( $pattern , $email ) ) ?  true : false ;
	}
}




/**
 * Checks if it's valid alpha character
 * 
 * @access public
 * @param string 
 * @return bool
 */
if( !function_exists('validate_alpha') ){
    function validate_alpha( $val ){
        return preg_match('/^[a-zA-Z]+$/', $val ) ? true : false ;
    }
}




/**
 * Checks if it's a valid numeric character
 * 
 * @param int $val 
 * @access public
 * @return bool - true on success and false on error
 */
if( !function_exists('validate_numeric') ){
    function validate_numeric( $val ){
        return is_numeric( $val ) ? true : false ;
    }
}




/**
 * Checks if it's a valid alpha numeric character 
 * 
 * @access public
 * @param int $val 
 * @return bool - true on success and false on error
 */
if( !function_exists('validate_numeric') ){
    function validate_numeric( $val ){
        return is_numeric( $val ) ? true : false ;
    }
}




/**
 * compare -  compares two variable
 * 
 * @access public
 * @param mixed 
 * @param mixed 
 * @return bool 
 */
if( !function_exists( 'validate_compare' ) ){
    function validate_compare( $val1 , $val2 ){
        return ( $val1 === $val2 ) ? true : false ;
    }
}





/**
 * Determines whether the value is greater than OR less than the specified conditions
 * 
 * @access public
 * @param int the number to be evaluated
 * @param int the maximum number
 * @param int the minimum number 
 * @return bool
 */
if( !function_exists( 'validate_length' ) ){
    function validate_length( $val , $max , $min ) {
        return ( !( strlen( $val ) > $max ) && !( strlen( $val ) < $min ) ) ? true : false ;
    }
}




/**
 * Check if it's a valid url address
 * 
 * @access public
 * @param string $url - the url address
 * @return bool - true on success and false on error
 */
if( !function_exists( 'validate_url' ) ){
    function validate_url( $url ){
        
        // note : use this if protocol checking is only used
        //return eregi("^(http|ftp|https)://", $url) ? true : false ;

        $protocol =  '((http|https|ftp)://)';
        $access = '(([a-z0-9_]+):([a-z0-9-_]*)@)?';
        $sub_domain = '(([a-z0-9_-]+\.)*)';
        $domain = '(([a-z0-9-]{2,})\.)';
        $tld  = '(com|net|xxx|org|edu|gov|mil|int|arpa|aero|biz|coop|info|museum|name|ad|ae|af|ag|ai|al|am|an|ao|aq|ar|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cf|cd|cg|ch|ci|ck|cl|cm|cn|co|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|ee|eg|eh|er|es|et|fi|fj|fk|fm|fo|fr|fx|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|mv|mw|mx|my|mz|na|nc|ne|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zr|zw)';
        $port = '(:(\d+))?';
        $path = '((/[a-z0-9-_.%~]*)*)?';
        $query = '(\?[^? ]*)?';
        $extra = "$`iU";

        $pattern = "`^" .$protocol. $access . $sub_domain . $domain . $tld . $port . $path . $query . $extra ;
        return  preg_match( $pattern,  $url ) ? true : false ;
    }
}




/**
 * Check if it's a valid url image address
 * 
 * @access public
 * @param string the url image address         
 * @return bool
 */
if( !function_exists( 'validate_image_url' ) ){
    function validate_image_url( $url ) {
        return eregi("^(http|ftp|https)://.+\.(jpg|jpeg|jpe|png|gif|bmp|wbmp|rle|dib|eps|pcx|tif|tiff)$", $url) ? true : false ;
    }
}





/**
 * Check if it's a valid date
 * 
 * @access public
 * @param date $date date in "YYYY-MM-FF" format
 * @return bool
 */
if( !function_exists( 'validate_date' ) ){
    function validate_date( $date ){
        $ret = false;
        $format = eregi("^[0-9]{4}-[0-9]{2}-[0-9]{2}($| [0-9]{2}:[0-9]{2}$)", ( $date ) );
        if ( $format ) {
            $splitDate = split( "-" , str_replace(" ", "-", trim( $date ) ) , 4 );
            $year =  $splitDate[0];
            $month = $splitDate[1];
            $day =   $splitDate[2];
            
            $ret = checkdate( $month , $day , $year );
        }
        return $ret;
    }
}




/**
 * Check if it's a valid date time formal
 * 
 * @param date $dateTime in "YYYY-MM-FF HH:MM:SS" format
 * @access public
 * @return bool
 */
if( !function_exists( 'validate_datetime' ) ){
    function validate_datetime( $date ){
        $ret = false;
        $format = eregi("^[0-9]{4}-[0-9]{2}-[0-9]{2}($| [0-9]{1,2}:[0-9]{1,2})($|:[0-9]{1,2}$)", ( $date ) );
        if ( $format ) {
            $splitDate = split( "-" , str_replace(" ", "-", trim( $date ) ) , 4 );
            $year =  $splitDate[0];
            $month = $splitDate[1];
            $day =   $splitDate[2];
            
            $ret = checkdate( $month , $day , $year );

            $tmpSplit = split(" ", trim($date));
            
            if(count($tmpSplit) > 1) {
                $splitTime = split(":", $tmpSplit[1]);

                $hour = $splitTime[0];
                $min = $splitTime[1];
                $sec = $splitTime[2];

                if($hour > 23)
                    $ret = false;

                if($min > 59)
                    $ret = false;

                if($sec > 59)
                    $ret = false;
            }
            
        }
        return $ret;
    }

}




/**
 * isUrlImage - check if it's a valid url image address
 * 
 * @access public
 * @param string $url the url image address        
 * @return bool 
 */
if( !function_exists( 'validate_image' ) ){
    function validate_image( $img ) {
        return eregi("^.+\.(jpg|jpeg|jpe|png|gif|bmp|wbmp|rle|dib|eps|pcx|tif|tiff)$", $img ) ? true : false ;
    }
}




?>
