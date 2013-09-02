<?php

    /**
     * Author: Harold Kim Cantil 
     */    

    Header("Cache-Control: must-revalidate");
    Header("Expires: " . gmdate( "D, d M Y H:i:s", time() +  60 * 60 * 24 * 3 ) . " GMT");

    set_time_limit(90);

    //ini_set( "session.cookie_secure" , "On" ); // VIA SSL?
    ini_set( "session.cookie_httponly" , "On" );
    
    @session_regenerate_id(false);
    @session_destroy();
    session_start();

    require_once "./system/core/bootstrap.php";    
    
    require_once SYSTEM_PATH . "/core/common.php";    
    require_once SYSTEM_PATH . "/core/loader.php";  
    require_once SYSTEM_PATH . "/core/admin.php";    

    require_once SYSTEM_PATH . "/library/action.php";    
    
    


    // TODO :: IP RESTRICTION 

    $maintenance = $CONFIG->search( array( "admin" , "maintenance" ) );    

    define( "MODULE" , strtolower( get( "module" ) ) );
    
    if( $maintenance === true && MODULE === "login" ){

            require_once SYSTEM_PATH . 'admin/view/manbintenance.php';
        exit();

    }else{

        // TODO :: Every pages will have some sort of notice.
        
        $app = new Admin( $debug_init);
        $app->index();

    }

?>
