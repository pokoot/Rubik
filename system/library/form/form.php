<?php

namespace Library;

if ( !defined('BASE_PATH')) exit('No direct script access allowed.');

class Form{

    public $yaml;

    public function __construct( $yaml ){
        $this->yaml = $yaml;
    }

    public function listing(){

        $listing = new \Library\Form\Listing( $this->yaml );
        $listing->query();
        
        $html = $listing->control();

        $html .= $listing->grid();

        return $html;

    }

    public function entry(){
        
    }

}

?>
