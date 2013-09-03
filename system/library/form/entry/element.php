<?php

namespace Library\Form\Entry;

if ( !defined('BASE_PATH')) exit('No direct script access allowed.');

class Element {

    public $yaml;

    public function __construct( $yaml ){
        $this->yaml = $yaml;
    }

    public function element(){

        $html = '<br/> elements goes here ...';

        $object = new \Library\Form\Entry\Element\Select( $this->yaml );
        $html .= $object->render();

        $object = new \Library\Form\Entry\Element\Upload( $this->yaml );
        $html .= $object->render();
    
        return $html;
    }

}
?>

