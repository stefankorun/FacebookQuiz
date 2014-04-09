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
		$this->mysqli->set_charset("utf8");
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
		
		if($query){
			$res = $query->fetch_assoc();
			if(sizeof($res) > 0)
				return $res;
			else
				return FALSE;//greska
		}
		else{
			echo "Error: " . $this->mysqli->error;
			return FALSE;
		}
	}
	
	function addUser($fbid, $name, $email, $tel){
		$query = $this->mysqli->query("INSERT INTO user(fb_id, name, email, tel, questionsLeft, points) VALUES(".$fbid.", '".$name."', '".$email."', '".$tel."', 10, 0)");
		
		if($query)
			return TRUE;
		else{
			echo "Error: " . $this->mysqli->error;
			return FALSE;
		}
	}
	
	function updateQuestionsLeft($fbid, $ql){
		$query = $this->mysqli->query("UPDATE user SET questionsLeft=".$ql." WHERE fb_id=".$fbid."");
		
		if($query)
			return TRUE;
		else{
			echo "Error: " . $this->mysqli->error;
			return FALSE;//greska
		}
	}
	
	function checkAnswer($qid, $answer){
		$queryQuestionPoints = $this->mysqli->query("SELECT answer FROM prasanja WHERE id=".$qid."");
		if($queryQuestionPoints){
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
		else{
			echo "Error: " . $this->mysqli->error;
			return FALSE;
		}
	}
	
	function getUserPoints($fbid){
		$queryQuestionPoints = $this->mysqli->query("SELECT * FROM user WHERE fb_id=".$fbid."");
		
		if($queryQuestionPoints){
			$res = $queryQuestionPoints->fetch_assoc();
			$points = $res['points'];
			
			if(sizeof($res))
				return $points;
			else
				return FALSE;//greska
		}
		else{
			echo "Error: " . $this->mysqli->error;
			return FALSE;
		}
	}
	
	function newUserAnswer($fbid, $qid, $points){
		$query = $this->mysqli->query("INSERT INTO userquestion(user_id, questionId, points) VALUES(".$fbid.", ".$qid.", ".$points.")");
		
		if($query)
			return TRUE;
		else{
			echo "Error: " . $this->mysqli->error;
			return FALSE;
		}
	}
	
	function updatePoints($fbid, $qid, $questionsLeft, $answer){
		$resAnswer = $this->checkAnswer($qid, $answer);
		if($resAnswer !== FALSE){
			$upoints = $this->getUserPoints($fbid);
			$newpoints = $resAnswer + $upoints;
			$query = $this->mysqli->query("UPDATE user SET questionsLeft=".$questionsLeft.", points=".$newpoints." WHERE fb_id=".$fbid."");
			if($query){
				$this->newUserAnswer($fbid, $qid, $resAnswer);
				return TRUE;
			}
			else{
				echo "Error: " . $this->mysqli->error;
				return FALSE;
			}
		}
		return FALSE;//greska
	}
	
	function getRandQuestion($fbid){
		
		$randQuestion=$this->mysqli->query('select * from questions p  where p.id NOT IN (SELECT uq.questionId FROM  userquestion uq where uq.user_id='.$fbid.') order by rand() limit 1');
		return $randQuestion->fetch_assoc();
	}
	
	function getUnfinishedQuestion($fbid){
		$unfinishedQuestion=$this->mysqli->query('select * from userquestion uq inner join questions p on p.id=uq.questionId where uq.user_id='.$fbid.' and points=-1 limit 1');
		if($unfinishedQuestion->num_rows>0){
			return $unfinishedQuestion->fetch_assoc();
		}
		else return false;
		
		
	}
	
	function validateAnswer($questionId,$answer,$fbid){
		$correctAnswer=$this->mysqli->query('select * from questions where id='.$questionId.' and correct='.$answer.' limit 1');
		if($correctAnswer->num_rows>0){
			$this->newUserAnswer($fbid,$questionId,10);
		}
		else{
			$this->newUserAnswer($fbid,$questionId,0);
		}
	}
}