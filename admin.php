<?php

    error_reporting( E_ALL );

    include_once "./system/helper/yaml.php";
    include_once "./system/library/spyc.php";
    

    $f = "./application/config/localhost.yml" ;

    $y = file_get_contents( $f );

    $arr = array(
        "database_username"     => "u1" , 
        "database_password"     => "passkey" ,
        "database_name"         => "db 1" 
    );    


   
    $x = yaml_replace( $arr ,  $y );

  

    $a = yaml_load_file(  $x );

    print_r( $a["database"]  );



?>
