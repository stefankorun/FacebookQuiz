<?php
/**
 * Created by PhpStorm.
 * User: korun
 * Date: 4/8/14
 * Time: 2:14 PM
 */

require_once("Question.php");


class Quiz {
    private $questions;

    public function __construct() {
        $this->questions = array();

        array_push($this->questions, new Question());
        array_push($this->questions, new Question());
    }

    public function showQizz() {
        $this->questions[0]->answers[0]->generateHtml();
    }
} 