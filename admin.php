<?php

    include_once "/system/helper/yaml.php";
    include_once "/system/library/spyc.php";
    

    $f = "./application/config/localhost.yml" ;

    $y = file_get_contents( $f );



    $arr = array(
        "AUTO_REPLACE_DB_USERNAME" => "u1" , 
        "AUTO_REPLACE_DB_PASSWORD"  => "passkey" 
    );
    
 
    $x = yaml_replace( $arr ,  $y );


    $a = yaml_load_file(  $x );

    print_r( $a );

 
    
 



?>
