<?php

    Header("Cache-Control: must-revalidate");
    Header("Expires: " . gmdate( "D, d M Y H:i:s", time() +  60 * 60 * 24 * 3 ) . " GMT");

    if( isset($_GET["debug"] ) ){
        $DEBUG = ( $_GET["debug"] == "true" ) ? true : false;       
    }

    set_time_limit(90);

    //ini_set( "session.cookie_secure" , "On" ); // VIA SSL?
    ini_set( "session.cookie_httponly" , "On" );

    @session_regenerate_id(false);
    @session_destroy();
    session_start();

    
    require_once "./system/core/bootstrap.php";    


    //include_once "./system/helper/yaml.php";
    //include_once "./system/library/spyc.php";    
    




?>
