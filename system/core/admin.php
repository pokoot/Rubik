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

    //protected $model;
    //protected $css;
    //protected $js;
    //protected $vendor;
    //protected $helper;
    //protected $library;

    protected $request;
    protected $yaml;

    public function  __construct(){
       
    }


    /**
     * Loading external vendor components 
     * 
     * @access private
     * @param mixed $controller 
     * @return void
     */
    private function load_vendor( $controller ){

        if( count( $controller->vendor ) == 0 ){
            return null;
        }   
        
        foreach( $controller->vendor AS $d ){

            $file = APPLICATION_PATH . "/vendor/$d/index.php";

            if( !file_exists( $file ) ){
                die( "Unable to load vendor. Please check \"$d\" vendor folder. and check index.php. ");
            }

            debug_init( "loading vendor file = $file " );

            require_once $file; 

        }
    
    }


    /**
     * Load external classes 
     * 
     * @access private
     * @param mixed $controller 
     * @return void
     */
    private function load_library( $controller ){

        if( count( $controller->library ) == 0 ){
            return null;
        }   
        
        foreach( $controller->library AS $f ){

            $file = APPLICATION_PATH . "/library/" . $f . ".php";             

            if( !file_exists( $file ) ){
                die( "Unable to load library file. Please check \"$f\" library file. ");
            }

            debug_init( "loading library file = $file " );

            require_once $file; 

        }
    }


    /**
     * Load the application helper files 
     * 
     * @access private
     * @param mixed $controller 
     * @return void
     */
    private function load_helper( $controller ){
    
        if( count( $controller->helper ) == 0 ){
            return null;
        }        
        
        foreach( $controller->helper AS $f ){

            $file = APPLICATION_PATH . "/helper/" . $f . ".php";             

            if( !file_exists( $file ) ){
                die( "Unable to load helper file. Please check \"$f\" helper file. ");
            }

            debug_init( "loading helper file = $file " );

            require_once $file; 

        }

              
        
 
    }

    
    /**
     * Include the model class and make it as an object property. 
     * 
     * @access private
     * @param mixed $controller 
     * @return void
     */
    private function load_model( $controller ){
 
        foreach( $controller->model AS $f ){

            $file = SYSTEM_PATH . "/admin/model/" . $f . ".php"; 
             
            if( !file_exists( $file ) ){
                $file = APPLICATION_PATH . "/admin/model/" . $f . ".php" ;
            }

            if( !file_exists( $file ) ){
                die( "Unable to load model file. Please check \"$f\" model class. ");
            }

            debug_init( "loading model file = $file " );

            require_once $file; 


            // Dynamically instantiate the namespace Model
            
            $class_name = "Model\\$f";
    
            $model = new $class_name();

            $property_name = $model->name;

            $controller->$property_name = $model;

        }

    } 


    /**
     * Load the .yml configuration file to the object property $controller->yaml 
     *
     * @access private
     * @param mixed $controller 
     */
    private function load_config( $controller ) {        

        $file = $controller->config;

        if( count( $file  ) > 1 ){
            die( 'Unable to proceed. Can only load 1 configuration file setting. Check controller code ... $this->config = array( "prototype" )' );
        }

        if( is_array( $file ) ){
            $file = $file[0];
        }

        $file = SYSTEM_PATH . "/admin/config/" . $file . ".yml"; 


        if( !file_exists( $file ) ){
            $file = APPLICATION_PATH . "/admin/config/" . $file . ".yml" ;
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

        $file = SYSTEM_PATH . "/admin/view/" . $template . ".php";

        if( !file_exists( $file ) ){
            die( "Unable to load view. Please check the view file if it does exist. ");
        }

        debug_init( "loading view file =  $file " );

        // TODO :: LOAD JS AND CSS

        require_once $file;    
    
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
     * First call, acts as a controller of the  
     * 
     * @access public
     * @return void
     */
    public function index(){

        $file = SYSTEM_PATH . "/admin/controller/" . MODULE . ".php";

        if( !file_exists( $file ) ){
            $file = APPLICATION_PATH . "/admin/controller/" . MODULE . ".php" ;
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
