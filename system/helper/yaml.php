<?php  

/**
 * Parses yaml string to an array. 
 * 
 * @access public
 * @param mixed $string 
 * @return array
 */
if(!function_exists('yaml_load_string')) {
    function yaml_load_string ($string) {
        return Spyc::YAMLLoadString($string);
    }
}




/**
 * Parses .yml file to an array.
 * @param string $file Path to YAML file.
 * @return array
 */
if( !function_exists('yaml_load_file') ){  
    function yaml_load_file ($file) {
        return Spyc::YAMLLoad($file);
    }
}




/**
 * Replace the ##CONTENT## to a specified value
 *
 * Similar to str_replace
 *
 * Example: 
 *
 *      $yaml = file_get_contents( "./test.yml" );
 *      $results = yaml_replace( array( "test" ) ,  $yaml , "##" );
 * 
 * @access public
 * @param mixed $arr 
 * @param mixed $yaml 
 * @return void
*/
if( !function_exists( "yaml_replace" ) ){
    
    function yaml_replace( $arr , $yaml , $pad = "%" ){ 

        $search = array();
        $replace = array();
        foreach( $arr AS $key => $value ){

            if( is_string( $value ) ){     
                
                $search[]   = $pad . $key . $pad;

                $replace[]  = nl2br( "{$value}" );
            }
        }
        
        return str_replace( $search , $replace , $yaml );
    }
}




/**
 * Converts an associative array to inline yaml array only
 * 
 * @access public
 * @param mixed $array 
 * @return void
 */
if( !function_exists( "yaml_array" ) ){
    
    function yaml_array( $array ){

        $temp = array();
        foreach( $array AS $key => $value ){

            if( is_array( $value ) ){

                $temp[] = "$key :" . yaml_array( $value );

            }else{
                $temp[] = $key . " : " . $value;
            }
        }
    
        return " { " . implode( ", " , $temp ) . " } ";
    }
}

?>
