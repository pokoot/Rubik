<?php  if ( !defined("BASE_PATH")) exit( "No direct script access allowed" );


/**
 * Encryption algorithm
 * 
 * @access public
 * @param string $text the string to be encrypted
 * @return void
 */
if( !function_exists( 'encrypt' ) ){    
    function encrypt( $text ){
        return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5( SITE_KEY ) , $text , MCRYPT_MODE_CBC, md5(md5( SITE_KEY ))));
    }
}

/**
 * Decryption algorithm 
 * 
 * @access public
 * @param mixed $text 
 * @return void
 */
if( !function_exists( "decrypt" ) ){    
    function decrypt( $text ){
        return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5( SITE_KEY ), base64_decode($text), MCRYPT_MODE_CBC, md5(md5( SITE_KEY))), "\0");
    }
}

?>
