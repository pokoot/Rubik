<?php 

if ( !defined('BASE_PATH')) exit('No direct script access allowed.');

class Prototype extends Admin implements Action{ 

    protected $config = array( "prototype" );
    protected $model = array( "prototype" , "account" );
    protected $helper;
    protected $library;
    protected $js;
    protected $css;
    protected $vendor;
 
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

        $this->Prototype->all();
        $this->Account->all();

        $data = array(
            "title"     => "Prototype" , 
            "request"   => $this->request             
        );

        $this->view( $data );


    }
  
}
?>
