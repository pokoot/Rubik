<?php 

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

    protected $model;
    protected $css;
    protected $js;
    
    protected $vendor;
    protected $helper;


    protected $request;
    protected $yaml;
    protected $config;
    protected $language;


    private function load_vendor(){
    
    }

    private function load_library(){
    
    }

    // todo
    private function load_model(){
    
    }

    private function load_config(){
    }


    public function request(){
        print "<Br/> from admin.php";
    } 

    /**
     * First call, acts as a controller of the  
     * 
     * @access public
     * @return void
     */
    public function index(){

        $file = SYSTEM_PATH . "admin/controller/" . MODULE . ".php";

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


        $module = MODULE;

        $controller = new $module();
        $controller->index();


        $this->load_config();

        
    }
}

?>
