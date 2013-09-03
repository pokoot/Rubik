<?php 

if ( !defined('BASE_PATH')) exit('No direct script access allowed.');

/**
 * A complex example of a controller class
 * 
 * @uses Admin
 * @uses Action
 * @package 
 * @version $id$
 * @author Harold Kim Cantil 
 * @license http://pokoot.com/license.txt
 */
class Complex extends Admin implements Action{     

    protected $model = array( "sample" );
    protected $helper = array( "sample" );
    protected $library = array( "sample" );
    protected $vendor;
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

        $form = new \Library\Form( $this->yaml );

        print "<Br/> listing ... ";
        print $form->listing();


        print "<Br> entry ... ";
        print $form->entry();
      
        $data = array(
            "title"     => "Complex" , 
            "request"   => $this->request             
        );

        $this->view( $data );

    }  

}
?>
