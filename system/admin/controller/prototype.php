<?php 

if ( !defined('BASE_PATH')) exit('No direct script access allowed.');

/**
 * TODO:: To have simple and complex examples. 
 * 
 * @uses Admin
 * @uses Action
 * @package 
 * @version $id$
 * @author Harold Kim Cantil 
 * @license http://pokoot.com/license.txt
 */
class Prototype extends Admin implements Action{     

    protected $model = array( "prototype" );
    protected $helper = array( "prototype" );
    protected $library = array( "sample" );
    protected $vendor = array( "sample" );
    protected $js;
    protected $css;
    
 
    public function __construct(){
    }

    public function request(){        
    }

    public function add(){
    }

    public function edit(){
    }

    public function delete(){
    }

    public function save(){
    }
 
    public function index(){        
        $this->request();
        $this->process();

        $data = array(
            "title"     => "Prototype" , 
            "request"   => $this->request             
        );

        $this->view( $data );

    }  

}
?>
