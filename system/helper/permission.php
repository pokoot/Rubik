<?php  if ( !defined("BASE_PATH")) exit( "No direct script access allowed" );



/**
 * Determines if a partials & pages can be accessed.
 *
 * Returns true is allowed
 *
 * @access public
 * @return void
 */
if( !function_exists('allow_access')){

    function allow_access( $rights = "" ){

        $rights = strtoupper( $rights );

        $allow = false;

        $permission = session_get( "permission" );

        if( $rights == "ALL" || $rights == "" || $permission == "SUPER" ){
            $allow = true;
        }else{

            $r = explode( "," , $rights );

            if( in_array( $permission , $r ) ){
                $allow = true;
            }
        }
        return $allow;
    }
}



?>
