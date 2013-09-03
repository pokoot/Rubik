<?php

namespace Library\Form\Entry;

if ( !defined('BASE_PATH')) exit('No direct script access allowed.');

class Button implements \Library\Form\Action{

    public $yaml;

    public function __construct( $yaml ){
        $this->yaml = $yaml;
    }

    public function validate(){
    }

    public function button(){

        $html = '<br/> button';
    
        return $html;
    }

}
?>
