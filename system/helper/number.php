<?php  if ( !defined("BASE_PATH")) exit( "No direct script access allowed" );


/**
 * Formats a numbers as bytes, based on size, and adds the appropriate suffix
 *
 * @access  public
 * @param   mixed   $num will be cast as int
 * @param   int     $precision
 * @return  string
 */
if( !function_exists('byte_format')){
    function byte_format($num, $precision = 1){

        if($num >= 1000000000000){
            $num = round($num / 1099511627776, $precision);
            $unit = __('TERABYTE_ABBR' , false );

        }elseif($num >= 1000000000){
            $num = round($num / 1073741824, $precision);
            $unit = __('GIGABYTE_ABBR' , false );
        }elseif($num >= 1000000){
            $num = round($num / 1048576, $precision);
            $unit = __('MEGABYTE_ABBR', false );
        }elseif($num >= 1000){
            $num = round($num / 1024, $precision);
            $unit = __('KILOBYTE_ABBR' , false );
        }else{
            $unit = __('BYTES' , false );
            return number_format($num).' '.$unit;
        }
        return number_format($num, $precision).' '.$unit;
    }
}


?>
