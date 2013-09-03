<?php

namespace Library\Form\Listing\Control\Grid;

class Text implements \Library\Form\Action{

    private $permission;
    private $type;
    private $align; 

    public $yaml;

    public function __construct( $yaml ){
        $this->yaml = $yaml;
    }

    public function validate(){
    }

    public function render(){
        $html = '';
        return $html;
    }

 
}


?>
