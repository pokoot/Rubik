<?php 

if ( !defined('BASE_PATH')) exit('No direct script access allowed.');

class Prototype extends Admin implements Action{ 

    protected $config = array( "prototype" );
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
