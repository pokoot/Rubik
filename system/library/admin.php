<?php

namespace Library;

if ( !defined('BASE_PATH')) exit('No direct script access allowed.');


/**
 * The admin controller
 * 
 * @package 
 * @version $id$
 * @author Harold Kim Cantil 
 * @license http://pokoot.com/license.txt
 */
class Admin{

    public $model;
    public $css;
    public $js;
    
    public $vendor;
    public $helper;


    public $request;
    public $yaml;
    public $config;
    public $language;

   

    public function index(){


        $file = SYSTEM_PATH . "controller/" . MODULE . ".php";

        if( !file_exists( $file ) ){
            $file = APPLICATION_PATH . "admin/controller/" . MODULE . ".php" ;
        }

        if( !file_exists( $file ) ){
            die( "Unable to load module. Please check your admin controller if it does exist. ");
        }

        require_once $file;

        if( !class_exists( MODULE ) ){
            die( "Unable to load module. The class already exist. Please check for possible class duplicates" );
        }

        

        
    }
}

?>
