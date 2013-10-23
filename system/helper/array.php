<?php  if ( !defined("BASE_PATH")) exit( "No direct script access allowed" );



/**
 * Element
 *
 * Lets you determine whether an array index is set and whether it has a value.
 * If the element is empty it returns false (or whatever you specify as the default value.)
 *
 * @access  public
 * @param   string
 * @param   array
 * @param   mixed
 * @return  mixed   depends on what the array contains
 */
if( !function_exists('element')){
    function element($item, $array, $default = false){
        if( !isset($array[$item]) OR $array[$item] == ""){
            return $default;
        }

        return $array[$item];
    }
}




/**
 * Elements
 *
 * Returns only the array items specified.  Will return a default value if
 * it is not set.
 *
 * @access  public
 * @param   array
 * @param   array
 * @param   mixed
 * @return  mixed   depends on what the array contains
 */
if( !function_exists('elements')){
    function elements($items, $array, $default = false){
        $return = array();

    if( !is_array($items)){
        $items = array($items);
        }

        foreach ($items as $item){
            if(isset($array[$item])){
                $return[$item] = $array[$item];

            }else{
                $return[$item] = $default;
            }

        }
        return $return;
    }
}



/**
 * Random Element - Takes an array as input and returns a random element
 *
 * @access  public
 * @param   array
 * @return  mixed   depends on what the array contains
 */
if( !function_exists('random_element')){
    function random_element($array){
        if(!is_array($array)){
            return $array;
        }
        return $array[array_rand($array)];
    }
}



/**
 * Split a clean string by string
 *
 * @access public
 * @param mixed $delimeter
 * @param mixed $string
 * @return void
 */
if( !function_exists( 'explode_clean' ) ){

    function explode_clean( $delimeter , $string ){

        if( !is_string( $string )){
            return $string;
        }

        $arr = explode( $delimeter , $string );

        $array = Array();
        foreach( $arr AS $v ){
            $array[] = clean( $v );
        }

        return $array;
    }
}

?>
