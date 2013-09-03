<?php

namespace Library\Form\Listing;

if ( !defined('BASE_PATH')) exit('No direct script access allowed.');

class Control{

    public $yaml;

    public function __construct( $yaml ){
        $this->yaml = $yaml;
    }

    public function search(){    
        $object = new \Library\Form\Listing\Control\Search( $this->yaml );
        return $object->search();
    }

    public function button(){
        $object = new \Library\Form\Listing\Control\Button( $this->yaml );
        return $object->button();
    }

    public function filter(){
        $object = new \Library\Form\Listing\Control\Filter( $this->yaml );
        return $object->filter();
    }

}
