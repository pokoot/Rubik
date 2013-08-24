<?php  if ( !defined("BASE_PATH")) exit( "No direct script access allowed" );


/**
 * Add history log to the database
 * 
 * @access public
 * @param mixed $table 
 * @param mixed $action 
 * @param mixed $id 
 * @return void
 */
if( !function_exists('history')){

    
    function history( $action , $table , $id ){

        // do a force checking due to previous version of central
        $actions = array( "LOGIN" , "ADD" , "EDIT" , "DELETE" , "SAVE" );

        if( !in_array( $action , $actions ) ){

            debug_header( "Please fix your history class parameters. history( \$action, \$table , \$id ); No history has been registered." , "#FFCCCC");
            
            return true;
        }

        // do a normal history insert
        
        $history = new History_Log();
        $history->save( $action , $table , $id );

    }


  
}


?>
