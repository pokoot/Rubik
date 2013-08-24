<?php  if ( !defined("BASE_PATH")) exit( "No direct script access allowed" );


/**
 * Start of output buffering
 * 
 * @access public
 * @return void
 */
if( !function_exists('debug_start') ){        
    function debug_start(){
        GLOBAL $DEBUG;
        if( $DEBUG == true ){        
            ob_start("debug_show");
            print "###DEBUG###";
        }
    }
}


/**
 * Cleans output buffers 
 * 
 * @access public
 * @return void
 */
if( !function_exists('debug_end') ){        
    function debug_end(){
        GLOBAL $DEBUG;
        if( $DEBUG == true ){
            ob_end_flush();
        }
    }
}
 



/**
 * Shows the debugging message
 * 
 * @access public
 * @return void
 */
if( !function_exists('debug_show') ){    
    function debug_show( $buffer ){
        GLOBAL $DEBUG_MESSAGE;
        
        return str_replace( "###DEBUG###",  
            "<table border='0' cellpadding='4' cellspacing='4' 
                style='background-color:#F5f5f5;font-size:12px;width:100%;font-familiy:arial;'
           
            >". $DEBUG_MESSAGE . "</table>", $buffer) ;
        
    }
}




/**
 *
 * Prints a formatted debugging message
 *
 * @access	public
 * @param	string	the message
 * @return	boolen 
 */
if( !function_exists('debug') ){
  
    function debug( $message , $backtrace = "" , $color = "#FFFFFF" ){
        GLOBAL $DEBUG , $DEBUG_MESSAGE;    

        if( !$backtrace ){
            $backtrace = debug_backtrace();    
        }
        foreach($backtrace AS $entry) {
            if( $entry['function'] ){
                $file = basename( $entry['file'] );

                if( $DEBUG ) {

                    $title  = $entry['file'];
                    $line   = $entry['line'];

                    // gets the current time
                    $timer = timer_get();
                        
                    $DEBUG_MESSAGE .= "
                        <tr style='background-color:$color;'>
                            <td style='text-align:right;width:130px;padding:6px;'><p title='$title'>$file</b></td>
                            <td style='text-align:center;width:50px;padding:6px;'>$line</td>
                            <td style='padding:6px;'>$message</td>            
                            <td style='text-align:center;width:50px;padding:6px;'>{$timer}s</td>
                        </tr>    
                    " ;
                }
                return true;
            }
        }
    }

}


/**
 * Debug header 
 * 
 * @access public
 * @param mixed $message 
 * @return void
 */
if( !function_exists('debug_header') ){

    function debug_header( $message , $color = "#FFFFCC" ){
        debug( strtoupper( $message ) , "" , $color );
    }

}




/**
 *
 * Prints a sql script
 *
 * @access	public
 * @param	string	the message
 * @return	boolen 
 */
if( !function_exists('debug_query') ){
    function debug_query( $message ){
        debug( "<pre>" . $message . "</pre>" , debug_backtrace() );
    }
}




/**
 *
 * Prints a the array formatted debugging message
 *
 * @access	public
 * @param	array	$value  the array to be dubugged 
 * @param   int     $level  depth of the loop
 * @return	boolen 
 */
if( !function_exists('debug_array') ){

    function debug_array( $value, $level=0 ){

        GLOBAL $DEBUG , $DEBUG_MESSAGE;
        $type= gettype($value);    

        if( $level == 0 ){

            $backtrace = debug_backtrace();
            foreach($backtrace AS $entry) {            
                if( $entry['function'] == __FUNCTION__) {
                    $file = basename( $entry['file'] );
                    if( $DEBUG ){

                        $line = $entry['line'];
                       
                        $DEBUG_MESSAGE .= "
                        <tr style='background-color:#FFFFFF;'>
                            <td style='text-align:right;width:130px;padding:6px;'>$file</td>
                            <td style='text-align:center;width:50px;padding:6px;'>$line</td>
                            <td style='padding:6px;'>           
                        " ;
                       


                    }
                }
            }

            if( $DEBUG ) $DEBUG_MESSAGE .= '<pre>';        
        }
     
        if( $type == 'string' ){
            $value = $value;
        }else if( $type=='boolean'){
            $value= ( $value ? 'true' : 'false');
        }else if( $type=='object'){
            $props = get_class_vars(get_class($value));
            if( $DEBUG ) $DEBUG_MESSAGE .= 'Object('.count($props).') <u>'.get_class($value).'</u>';
            foreach($props as $key=>$val){                
                
                if( $DEBUG ) $DEBUG_MESSAGE .= "\n" . str_repeat("&nbsp;", ($level+1) * 4 ) . "[" . $key . "]" . ' => ';
                debug_array( $value->$key , $level+1 );
            }
            $value= '';
        }else if( $type == 'array' ){
            if( $DEBUG ) $DEBUG_MESSAGE .= ucfirst( $type ) . '('.count($value).')';
            foreach($value as $key => $val){
                
                if( $DEBUG )  $DEBUG_MESSAGE .= "\n" . str_repeat( "&nbsp;" , ( $level+1 ) * 4 ) . "[" . $key . "]" . ' => ';
                debug_array( $val , $level+1 );
            }
            $value= '';
        }
         
        if( $DEBUG ) $DEBUG_MESSAGE .= "$value";
        if( $level==0 ){
            if( $DEBUG ){
                 $DEBUG_MESSAGE .= '</td></tr>';
            }
        }
    }
    
    return null;
}




?>
