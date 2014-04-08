<html>
<head>
   <meta charset="utf-8"/>
</head>
</html>
<?php

include_once("external/simple_html_dom.php");

class Answer {
    private $id;

    public $text;
    public $is_correct;

    public function __construct(){
        $this->id = '-1';
        $this->text = 'An answer';
        $this->is_correct = 'false';
    }

    public function generateHtml() {
        $html = new simple_html_dom();
        $html->load_file('design/index.html');
        echo $html->find(".col-sm-6", 0);
    }
}