<?php

class DBManager
{
	private $host = '127.0.0.1';
	private $username = 'root';
	private $pass = '';
	private $database = 'kliz_autodesk';
	private $mysqli;
	private $port;
	
	function connect()
	{
		$this->mysqli= new mysqli($this->host, $this->username, $this->pass, $this->database) or die();
		if ($this->mysqli->connect_errno) {
			echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
			return FALSE;
		}
		return TRUE;
	}
	
	function CloseConnection()
	{
		$this->mysqli->close();
	}
	
	function __construct()
	{
		$this->connect();
	}
	
	function getUserByFbid($fbid){
		$query = $this->mysqli->query("SELECT * FROM user WHERE fb_id=".$fbid."");
		$res = $query->fetch_assoc();
		
		if(sizeof($res) > 0)
			return $res;
		else
			return FALSE;//greska
	}
	
	function addUser($fbid, $name, $email, $tel){
		$query = $this->mysqli->query("INSERT INTO user(fb_id, name, email, tel, questionsLeft, points) VALUES(".$fbid.", '".$name."', '".$email."', '".$tel."', 10, 0)");
		
		if($query)
			return TRUE;
		else 
			return FALSE;
	}
	
	function updateQuestionsLeft($fbid, $ql){
		$query = $this->mysqli->query("UPDATE user SET questionsLeft=".$ql." WHERE fb_id=".$fbid."");
		
		if($query)
			return TRUE;
		else 
			return FALSE;//greska
	}
	
	function checkAnswer($qid, $answer){
		$queryQuestionPoints = $this->mysqli->query("SELECT answer FROM prasanja WHERE id=".$qid."");
		$res = $queryQuestionPoints->fetch_assoc();
		
		if(sizeof($res)){
			if($res['answer'] == $answer){//ako e tocen odgovorot 10 poeni
				return 10;
			}
			else{// ako ne 0
				return 0;
			}
		}
		else{
			return FALSE;//greska...
		}
	}
	
	function getUserPoints($fbid){
		$queryQuestionPoints = $this->mysqli->query("SELECT * FROM user WHERE fb_id=".$fbid."");
		$res = $queryQuestionPoints->fetch_assoc();
		$points = $res['points'];
		
		if(sizeof($res))
			return $points;
		else
			return FALSE;//greska
	}
	
	function newUserAnswer($fbid, $qid, $points){
		$query = $this->mysqli->query("INSERT INTO userquestion(user_id, questionId, points) VALUES(".$fbid.", ".$qid.", ".$points.")");
		
		if($query)
			return TRUE;
		else
			return FALSE;
	}
	
	function updatePoints($fbid, $qid, $questionsLeft, $answer){
		$resAnswer = $this->checkAnswer($qid, $answer);
		if($resAnswer !== FALSE){
			$upoints = $this->getUserPoints($fbid);
			$newpoints = $resAnswer + $upoints;
			$query = $this->mysqli->query("UPDATE user SET questionsLeft=".$questionsLeft.", points=".$newpoints." WHERE fb_id=".$fbid."");
			$this->newUserAnswer($fbid, $qid, $resAnswer);
			
			if($query)
				return TRUE;
			else 
				return FALSE;//greska
		}
		return FALSE;//greska
	}
}