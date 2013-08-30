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
    protected $library;

    protected $request;
    protected $yaml;

    public function  __construct(){
       
    }


    private function load_vendor( $controller ){
    
    }

    private function load_library( $controller ){
    
    }

    private function load_helper( $controller ){
    }

    
    private function load_model( $controller ){
 
        foreach( $controller->model AS $f ){

            $file = SYSTEM_PATH . "model/" . $f . ".php"; 
             
            if( !file_exists( $file ) ){
                $file = APPLICATION_PATH . "model/" . $f . ".php" ;
            }

            if( !file_exists( $file ) ){
                die( "Unable to load model file. Please check \"$f\" model class. ");
            }

            debug_init( "loading model file = $file " );

            require_once $file;

            $this->instantiate_model( $controller , $f );

        }

    }


    private function instantiate_model( $controller , $model ){

        $class_name = "Model\\$model";
    
        $m = new $class_name();

        $name = $m->name;
 
        $controller->$name = $m;

        return $m;
    }




    /**
     * Load the .yml configuration file to the object property $controller->yaml 
     */
    private function load_config( $controller ) {        

        $file = $controller->config;

        if( count( $file  ) > 1 ){
            die( 'Unable to proceed. Can only load 1 configuration file setting. Check controller code ... $this->config = array( "prototype" )' );
        }

        if( is_array( $file ) ){
            $file = $file[0];
        }

        $file = SYSTEM_PATH . "admin/config/" . $file . ".yml"; 


        if( !file_exists( $file ) ){
            $file = APPLICATION_PATH . "admin/config/" . $file . ".yml" ;
        }

        if( !file_exists( $file ) ){
            die( "Unable to load .yml configuration file. Please check your .yml configuration file if it does exist. ");
        }


        debug_init( "loading config file = $file " );

        $yaml = file_get_contents( $file );

        $controller->yaml = $yaml;

 
        return $contoller;
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

        debug_init( "loading view file =  $file " );

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


        $this->load_config( $controller );
        $this->load_helper( $controller );
        $this->load_library( $controller );
        $this->load_vendor( $controller );
        $this->load_model( $controller );

        //print_r( $controller->yaml );



        $controller->index();

        
    }
}

?>
