<?php

namespace Library\Form;

if ( !defined('BASE_PATH')) exit('No direct script access allowed.');

class Listing{

    public $yaml;

    public function __construct( $yaml ){
        $this->yaml = $yaml;
    }

    public function query(){

        $object = new \Library\Form\Listing\Query( $this->yaml );
        $statement = $object->query();

        return $statement;
    }

    public function control(){

        $object = new \Library\Form\Listing\Control( $this->yaml );
        
        $html = $object->search();

        $html .= $object->button();

        $html .= $object->filter();

        return $html;
    }

    
    public function grid(){
        $object = new \Library\Form\Listing\Control\Grid( $this->yaml );
        $html = $object->grid();
        return $html;
    }
}


?>
