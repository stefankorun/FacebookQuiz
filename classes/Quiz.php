<?php
/**
 * Created by PhpStorm.
 * User: korun
 * Date: 4/8/14
 * Time: 2:14 PM
 */


class Quiz {
    private $questions;

    public function __construct() {
        $this->questions = array();

        array_push($this->questions, new Question());
        array_push($this->questions, new Question());
    }

    public function showQizz() {
        return print_r($this);
    }
} 