<?php

namespace Library\Form;

if ( !defined('BASE_PATH')) exit('No direct script access allowed.');

class Listing{

    public $config;

    public $config_query;
    public $config_control;
    public $config_grid;

    public function __construct( $config ){

        $this->config = $config;

        $this->config_query     = element( "query" , $config );
        $this->config_control   = element( "control" , $config );
        $this->config_grid      = element( "grid" , $condfig );

    }

    public function query(){

        $object = new \Library\Form\Listing\Query( $this->config_query );
        $statement = $object->query();

        return $statement;
    }

    public function control(){

        $object = new \Library\Form\Listing\Control( $this->config_control );
        
        $html = $object->search();

        $html .= $object->button();

        $html .= $object->filter();

        return $html;
    }

    public function grid(){
    
        $object = new \Library\Form\Listing\Control\Grid( $this->config_grid );

        $html = $object->grid();

        return $html;
    }

}


?>
