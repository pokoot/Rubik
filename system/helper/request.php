<?php  if ( !defined("BASE_PATH")) exit( "No direct script access allowed" );



/**
 * Process post request ( $_POST )
 * 
 * @access public
 * @param mixed $val 
 * @param string $default 
 * @return void
 */
if( !function_exists('post')){
    function post( $val , $default = '' , $clean = false ){

        if( !empty( $_POST ) ){            
            
            if( array_key_exists( $val , $_POST ) ){
                if( is_array( $_POST[ $val ] ) ){

                    return ( $clean == true ) ?
                        clean( $_POST[ $val ] ) :
                        $_POST[ $val ];
                        
                }else{ 
                    return ( $clean == true ) ?
                        clean( trim( $_POST[ $val ] ) ) :
                        trim( $_POST[ $val ] ) ;
                }
            }
            
        }
        return $default;
    }       
}




/**
 * Process get request ( $_GETb )
 * 
 * @access public
 * @param mixed $val 
 * @param string $default 
 * @return void
 */

if( !function_exists('get')){
    
    function get( $val , $default = '' , $clean = false ){

        if( !empty( $_GET ) ){            
            
            if( array_key_exists( $val , $_GET ) ){

                if( $clean ){                    

                    if( is_array( $_GET[ $val ] ) ){
                        return $_GET[ $val ];
                    }else{
                        return clean( trim( $_GET[ $val ] ) ) ;
                    }
                
                }else{

                    if( is_array( $_GET[ $val ] ) ){
                        return $_GET[ $val ];
                    }else{
                        return trim( $_GET[ $val ] ) ;
                    }

                }
              

            }
            
        }
        return $default;
    }       
}




/**
 * Double $_POST. 
 *
 * Returns true if double post.
 * Returns false 
 * 
 * @access public
 * @return void
*/
if( !function_exists('f5')){
    
    function f5(){

        //print "<Br/> session = " . session_get( "refresh") ;
        //print "<Br/> post session = " . post( "refresh" );

        if( session_get( "refresh") == post( "refresh" ) ){
            session_set( "refresh" , "" );
            return false;
        }else{
            return true;
        }
    }
}



/**
 * Can be post or get method 
 * The method variables are cleaned.
 * 
 * @access public
 * @param mixed $val 
 * @param string $default 
 * @return void
 */
if( !function_exists( 'request' ) ){
    
    function request( $val , $default = ""  ){
        if( $_POST ){
            return post( $val , $default , true );
        }
        return get( $val , $default , true );        
    }
}

  
?>
