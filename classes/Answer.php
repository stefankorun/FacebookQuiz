<html>
<head>
   <meta charset="utf-8"/>
</head>
</html>
<?php

include_once("external/simple_html_dom.php");

class Answer {
    public $text;

    public function __construct($text){
        $this->text = $text;
    }

    public function render($html_location) {
        $html = new simple_html_dom();
        $html->load_file($html_location);
        $answer_div = $html->find(".php_answer_html", 0);

        $text = $answer_div->find(".php_answer_text", 0);
        $text->innertext = $this->text;

        return $answer_div;
    }
}