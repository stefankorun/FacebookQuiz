<?php

class Answer {
    private $id;

    public $text;
    public $is_correct;

    public function __construct(){
        $this->id = '-1';
        $this->text = 'An answer';
        $this->is_correct = 'false';
    }
} 