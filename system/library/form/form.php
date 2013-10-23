<?php

namespace Library;

if ( !defined('BASE_PATH')) exit('No direct script access allowed.');

class Form{

    private $config_listing;
    private $config_entry;

    public $yaml;

    public function __construct( $yaml ){

        $this->yaml = $yaml;

        $config = yaml_load_string( $yaml );

        $this->config_listing   = element( "listing" , $config );
        $this->config_entry     = element( "entry" , $config );

    }

    public function listing(){

        $listing = new \Library\Form\Listing( $this->config_listing );

        $listing->query();

        $html = $listing->control();

        $html .= $listing->grid();

        return $html;

    }

    public function entry(){

        $entry = new \Library\Form\Entry( $this->config_entry );

        $html = $entry->button();

        $html .= $entry->element();

        return $html;

    }

}

?>
