<?php
/**
 * Created by PhpStorm.
 * User: korun
 * Date: 4/8/14
 * Time: 2:17 PM
 */

class Question {
    private $questionID;
    public $answers;

    public function __construct() {
        $this->answers = array();

        array_push($this->answers, new Answer());
        array_push($this->answers, new Answer());
        array_push($this->answers, new Answer());
        array_push($this->answers, new Answer());

    }

} 