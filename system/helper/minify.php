<?php  if ( !defined("BASE_PATH")) exit( "No direct script access allowed" );


/**
 * Removes unwanted string.
 *
 * @access public
 * @param mixed $buffer
 * @return void
 */
if( !function_exists('minify') ){

    function minify( $buffer ) {
        /* remove comments */
        $buffer = preg_replace("/((?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:\/\/.*))/", "", $buffer);
        /* remove tabs, spaces, newlines, etc. */
        $buffer = str_replace(array("\r\n","\r","\t","\n",'  ','    ','     '), '', $buffer);
        /* remove other spaces before/after ) */
        $buffer = preg_replace(array('(( )+\))','(\)( )+)'), ')', $buffer);
        return $buffer;
    }

}

?>
