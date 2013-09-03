<?php

namespace Library\Form;

if ( ! defined("BASE_PATH")) exit("No direct script access allowed");

interface Action {
    public function validate();
}

?>
