<?php
/**
 * Created by PhpStorm.
 * User: korun
 * Date: 4/8/14
 * Time: 4:56 PM
 */

class Answer {
    private $id;

    public $text;
    public $is_correct;

    public function __construct(){
        $this->id = '-1';
        $this->$text = 'An answer';
        $this->$is_correct = 'false';
    }
} 