<?php

if ( !defined('BASE_PATH')) exit('No direct script access allowed.');

class Prototype extends Admin implements Aeds{ 

    protected $config = array( "prototype" );
    protected $model = array( "prototype" );
    protected $helper;
    protected $library;
    protected $js;
    protected $css;
    protected $vendor;

    public function __construct(){
        print "<Br/> here ";
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
        print "<br/> testing ... ";
    }
  
}
?>
