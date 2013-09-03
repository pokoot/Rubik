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

            $filename = "/vendor/$d/index.php";

            $file = APPLICATION_PATH . $filename ;

            if( !file_exists( $file ) ){                
                die( "Unable to load vendor ($filename).");
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

            $filename = "/library/" . $f . ".php";

            $file = APPLICATION_PATH . $filename;             

            if( !file_exists( $file ) ){                
                die( "Unable to load library file ($filename).");
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

            $filename = "/helper/" . $f . ".php";

            $file = APPLICATION_PATH . $filename;             

            if( !file_exists( $file ) ){                
                die( "Unable to load helper file ($filename).");
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

            $filename = "/admin/model/" . $f . ".php";

            $file = SYSTEM_PATH . $filename ; 
             
            if( !file_exists( $file ) ){
                $file = APPLICATION_PATH . $filename ;
            }

            if( !file_exists( $file ) ){                
                die( "Unable to load model file ($filename). ");
            }

            debug_init( "loading model file = $file " );

            require_once $file; 
            

            // Dynamically instantiate the namespace Model
            
            $namespace_name = "Model\\$f";
    
            $object = new $namespace_name();

            // Get the class name automatically without the namespaces.
            
            $class_name = get_class( $object );
            if (preg_match('@\\\\([\w]+)$@', $class_name, $matches)) {
                $class_name = $matches[1];
            }

            $controller->$class_name = $object;

        }

    } 


    /**
     * Load the .yml configuration file to the object property $controller->yaml 
     *
     * @access private
     * @param mixed $controller 
     */
    private function load_config( $controller ) {

        $filename = "/admin/config/" . MODULE . ".yml";

        $file = SYSTEM_PATH . $filename; 

        if( !file_exists( $file ) ){
            $file = APPLICATION_PATH . $filename ;
        }

        if( !file_exists( $file ) ){            
            die( "Unable to load .yml configuration file ($filename).");
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

        $filename = "/admin/view/" . $template . ".php";

        $file = SYSTEM_PATH . $filename;

        if( !file_exists( $file ) ){            
            die( "Unable to load view ($filename).");
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

        $filename = "/admin/controller/" . MODULE . ".php";

        $file = SYSTEM_PATH . $filename ;

        if( !file_exists( $file ) ){
            $file = APPLICATION_PATH . $filename ;
        }

        if( !file_exists( $file ) ){            
            die( "Unable to load module ($filename).");
        }

        require_once $file;

        if( !class_exists( MODULE ) ){
            die( "Unable to load module, the class already exist (" . MODULE . ")." );
        }


        $module = MODULE;

        $controller = new $module();     


        $this->load_config( $controller );
        $this->load_model( $controller );
        $this->load_helper( $controller );
        $this->load_library( $controller );
        $this->load_vendor( $controller );
        
        //print_r( $controller->yaml );

        $controller->index();

        
    }
}

?>
