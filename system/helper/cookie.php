<?php  if ( !defined("BASE_PATH")) exit( "No direct script access allowed" );



/**
 * Set cookie
 *
 * @access	public
 * @param	string  the name of the cookie
 * @param	string	the value of the cookie
 * @param	string	the number of seconds until expiration
 * @param	string	the cookie path
 * @param	string	the cookie domain.  Usually:  .yourdomain.com
 * @return	void
 */
if( !function_exists( "cookie_set" )){
    function cookie_set( $name, $value, $expiry = "LIFEFTIME" , $path = "/" ,
        $domain = false ){
        $retval = false;

        if(!headers_sent()){

            if( $domain === false){
                $domain = $_SERVER['HTTP_HOST'];

                // fix on ie
                if( $domain === "localhost" ){
                    $domain = "";
                }

            }


            if($expiry === "LIFEFTIME" ){
                $expiry = 1893456000;
            }elseif(is_numeric($expiry)){
                $expiry += time();
            }else{
                $expiry = strtotime($expiry);
            }



            $retval = setcookie( COOKIE_PREFIX . $name , $value , $expiry , $path , $domain , $secure = true , $httponly = true ) ;

            /*
            print "<br/> name = $name ";
            print "<br/> value = $value ";
            print "<br/> expiry = $expiry ";
            print "<br/> path = $path ";
            print "<br/> domain = $domain ";
            */


            if( $retval ){
                $_COOKIE[ COOKIE_PREFIX . $name] = $value;
            }

        }else{
            debug( "Error: Headers already sent. Unable to set cookie = $name " , debug_backtrace() );
        }
        return $retval;
    }
}




/**
 * Fetch an item from the COOKIE array
 *
 * @access	public
 * @param	string
 * @param	bool
 * @return	mixed
 */
if( !function_exists("cookie_get") ){
    function cookie_get( $name  , $default = "" ){
         return (isset($_COOKIE[ COOKIE_PREFIX . $name]) ? $_COOKIE[ COOKIE_PREFIX . $name] : $default );
    }
}



/**
 * Delete a COOKIE
 *
 * @param	string  the cookie name
 * @param	string	the cookie path
 * @param	string	the cookie domain.  Usually:  .yourdomain.com
 * @param	string	the cookie prefix
 * @return	void
 */
if( !function_exists("cookie_delete")){
    function cookie_delete( $name , $path = "/" , $domain = false , $remove_from_global = false ){

        $retval = false;

        if(!headers_sent()){

            if($domain === false){
                $domain = $_SERVER['HTTP_HOST'];
            }

            $retval = setcookie( COOKIE_PREFIX . $name, "" , time() - 3600 , $path, $domain , $secure = true , $httponly = true );

            if( $remove_from_global ){
                unset($_COOKIE[ COOKIE_PREFIX . $name]);
            }
        }else{
            debug( "Error: Headers already sent. Unable to delete cookie = $name " , debug_backtrace() );
        }
        return $retval;
    }

}


?>
