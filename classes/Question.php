<?php

require_once("Answer.php");

class Question {
    private $id;
    public $text;
    public $answers;

    public function __construct($data) {
        $this->id = $data["id"];
        $this->text = $data["text"];
        $this->answers = $this->parseAnswers($data["answers"]);
    }

    private function parseAnswers($data) {
        $answers = array();
        $dec_data = json_decode($data);

        $dec_data = $dec_data->answers;
        foreach($dec_data as $a) {
            $answers[] = new Answer($a);
        }
        return $answers;
    }

    public function render($html_location) {
        $html = "";

        foreach($this->answers as $a) {
            $html .= $a->render($html_location);
        }
        return $html;
    }
}