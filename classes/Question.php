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
        $html = new simple_html_dom();
        $html->load_file($html_location);

        $qa_div = $html->find(".php_qa_container", 0);

        $qa_div->find(".php_question", 0)->innertext = $this->text;

        $answers_html = "";
        foreach($this->answers as $a) {
            $answers_html .= $a->render($html_location);
        }
        $qa_div->find(".php_answers_container", 0)->innertext = $answers_html;

        return $html;
    }
}