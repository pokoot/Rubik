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

   
    /**
     * Tells whether it is add, edit, delete and save ... 
     * 
     * @access public
     * @return void
     */
    public function process(){

        $action = strtoupper( post( "action" ) );

        switch( $action ){

            case "DELETE" :
                $this->delete();
                $this->request["action"] = "LISTING";
                break;

            case "ADD" :
                $this->add();
                break;

            case "EDIT" :
                $this->edit();
                break;

            case "SAVE" :

                $this->request["action"] = "LISTING";

                if( f5() ){
                    break;
                }

                $this->save();
              
                if( isset( $this->request["required"] ) ){
                    $this->request["action"] = ( $this->request["entry_id"] ) ? "EDIT" : "ADD" ;
                }

                break;
            default:
                break;
        }

       
    }


    /**
     * Load the template html view file 
     * 
     * @access public
     * @param string $html 
     * @param array $param 
     * @return void
     */
    public function view( $param  = array() , $template = "default" ){

        if( is_array( $param ) && count( $param ) > 0){
            extract( $param , EXTR_PREFIX_SAME, "duplicate" );
        }

        $file = SYSTEM_PATH . "admin/view/" . $template . ".php";

        if( !file_exists( $file ) ){
            die( "Unable to load view. Please check the view file if it does exist. ");
        }

        require_once $file;    
    
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
