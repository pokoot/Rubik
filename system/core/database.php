<?php   if ( !defined('BASE_PATH')) exit('No direct script access allowed.');

    /**
     * Author: Kim     
     */
    

    
    $db             = $CONFIG->item( "database" );

    $db_host        = $db["host"];
    $db_username    = $db["username"];
    $db_password    = $db["password"];
    $db_name        = $db["name"];



    // open a connection to a mysql server    	
    $db_conn = mysql_connect( $db_host , $db_username , $db_password );

    if( !$db_conn ){
        die('could not connect :'.mysql_error() );
        exit();       
    } 

    // select a mysql database   
    $db_selected = mysql_select_db( $db_name , $db_conn );

    if( !$db_selected ){
        die ('Cant use the '. $database . ' : ' . mysql_error() );
        exit();
    }

    mysql_query( "SET character_set_client=utf8" );
    mysql_query( "SET character_set_connection=utf8" );
    mysql_query( "SET character_set_results=utf8" );

    //mysql_query( "SET names utf8" );

?>
