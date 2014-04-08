<?php

require_once("Answer.php");

class Question {
    private $questionID;
    public $answers;

    public function __construct() {
        $this->questionID = '-1';
        $this->answers = array();

        array_push($this->answers, new Answer());
        array_push($this->answers, new Answer());
        array_push($this->answers, new Answer());
        array_push($this->answers, new Answer());

    }

} 