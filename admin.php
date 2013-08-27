<?php

    Header("Cache-Control: must-revalidate");
    Header("Expires: " . gmdate( "D, d M Y H:i:s", time() +  60 * 60 * 24 * 3 ) . " GMT");

    set_time_limit(90);

    //ini_set( "session.cookie_secure" , "On" ); // VIA SSL?
    ini_set( "session.cookie_httponly" , "On" );

    @session_regenerate_id(false);
    @session_destroy();
    session_start();

    require_once "./system/core/bootstrap.php";    
    require_once "./system/core/loader.php";    

?>
