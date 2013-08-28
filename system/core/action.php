<?php  

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
    public function index();
}

?>
