<?php 

if ( !defined('BASE_PATH')) exit('No direct script access allowed.');

class Prototype extends Admin implements Aeds, Action{ 

    protected $config = array( "prototype" );
    protected $model = array( "prototype" );
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

    public function request(){
        print "<Br/> from prototype.php";
    }
    public function index(){
    }
  
}
?>
