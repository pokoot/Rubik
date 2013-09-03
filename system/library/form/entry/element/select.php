<?php

namespace Library\Form\Entry\Element; 

if ( !defined('BASE_PATH')) exit('No direct script access allowed.');

class Select implements \Library\Form\Action{

    public $yaml;

    public function __construct( $yaml ){
        $this->yaml = $yaml;
    }

    public function validate(){
    }

    public function render(){

        $html = '<br/> elemet = select render';
    
        return $html;
    }

}
?>

