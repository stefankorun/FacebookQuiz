<?php

require_once("classes/User.php");

$u=new User();
$u->getNextQuestion();
$u->validateAnswer('23432',1,3);

