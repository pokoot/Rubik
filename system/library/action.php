<?php

// Note: Don't use namespace for cleaner codes

if ( ! defined("BASE_PATH")) exit("No direct script access allowed");

/** 
 * actions
 *
 * @package 
 * @version $id$
 * @author Harold Kim Cantil 
 * @license http://pokoot.com/license.txt
 */
interface Action{
    public function request();
    public function add();
    public function edit();
    public function delete();
    public function save();
    public function index();
}

?>
