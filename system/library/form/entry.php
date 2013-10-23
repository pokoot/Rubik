<?php

namespace Library\Form;

if ( !defined('BASE_PATH')) exit('No direct script access allowed.');

class Entry{

    public $yaml;

    public function __construct( $yaml ){
        $this->yaml = $yaml;
    }

    public function button(){

        $object = new \Library\Form\Entry\Button( $this->yaml );
        $html = $object->button();

        return $html;
    }

    public function element(){

        $object = new \Library\Form\Entry\Element( $this->yaml );

        $html = $object->element();

        return $html;
    }


}


?>

