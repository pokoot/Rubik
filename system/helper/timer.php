<?php

/**
 * Initialize the start time profiling
 *
 * @access public
 * @return void
 */
if( !function_exists('timer_start')){

    function timer_start(){
        GLOBAL $TIME;
        $TIME = 0;
        $time = explode(' ',microtime());
        $TIME = $time[1].substr($time[0],1);
    }
}


/**
 * Get the current timing in script profiling
 *
 * @access public
 * @param float $decimal
 * @return void
 */
if( !function_exists('timer_get')){

    function timer_get( $decimal = 4 ) {
        GLOBAL $TIME;
        $time = explode(" ",microtime());
        $end_time = $time[1].substr( $time[0] ,1 );
        return number_format( bcsub( $end_time, $TIME  , 4 ) , $decimal );
    }

}

?>
