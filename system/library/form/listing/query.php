<?php

namespace Library\Form\Listing;

if ( !defined('BASE_PATH')) exit('No direct script access allowed.');

class Query implements \Library\Form\Action{

    private $display;
    private $total;
    private $select;
    private $from;
    private $where;
    private $group;
    private $order;

    public $yaml;

    public function __construct( $yaml ){
        $this->yaml = $yaml;
    }

    public function validate(){
    }

    public function query(){        
    }
    
}

?>
