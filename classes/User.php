<?php
require_once 'DBManager.php';
require_once 'Question.php';

class User{
	private $info = array();//info za user
	private $permission; //0 - ne smejt da go prajt kvizot, 1 - smejt
	private static $max_questions = 10;
	
	function __construct(/*$fbid, $name, $email, $tel*/){
		/*$db_user_info = $this->getUserInfo($fbid);
		if($db_user_info != NULL){
			$this->setUserInfo($db_user_info);
			$this->setUserPermission();
		}
		else{
			$this->addUser($fbid, $name, $email, $tel);
			$this->permission = 1;
		}*/
	}

	//postavuvanje permisii za dali smejt ili ne da prajt kviz
	private function setUserPermission(){
		if(($this->info['questionsLeft'] > 0)){
			$this->permission = 1;
		}
		else{
			$this->permission = 0;
		}
	}
	
	//vrakja informacii za korisnikot ako postoi ili null ako ne postoi
	public function getUserInfo($fbid){
		$result = array();
		$db = new DBManager();
		$result = $db->getUserByFbid($fbid);
		$db->CloseConnection();
		
		if($result === FALSE){//korisnikot ne e vnesen vo bazata
			return NULL;
		}
		else
			return $result;
	}
	
	//populnuvanje info za user
	public function setUserInfo($db_user_info){
		$this->info = array(
				"fbid" => $db_user_info['fb_id'], 	//id od facebook
				"name" => $db_user_info['name'], 	//fb ime
				"email" => $db_user_info['email'], 	//email so trebit sam da go vnesit
				"tel" => $db_user_info['tel'],
				"questionsLeft" => $db_user_info['questionsLeft'], 	// 0 - ne go imat napraeno, 1 - go imat napraeno
				"points" => $db_user_info['points'] // poeni od kvizot
		);
		$this->setUserPermission();
	}
	
	//dodava user vo baza i ja popolnuva klasata so podatoci
	//vrakja TRUE ako ima greska i false ako nema
	public function addUser($fbid, $name, $email, $tel){
		$db = new DBManager();
		$err = $db->addUser($fbid, $name, $email, $tel);
		$db->CloseConnection();
		
		if($err === FALSE){//ima greska
			return FALSE;
		}
		else{//nema greska
			$this->setUserInfo(array(
					"fb_id" => $fbid,
					"name" => $name,
					"email" => $email,
					"tel" => $tel,
					"questionsLeft" => 10,
					"points" => 0
			));
			
			return TRUE;
		}
	}
	
	
	//provervis dali smejt da go prajt kvizot ili ne
	public function getPermission(){
		return $this->permission;
	}
	
	//vrakjat info za user
	public function getInfo(){
		return $this->info;
	}
	
	//se povikuva koga korisnikot ke odgovori na prasanje so id X
	public function newAnswer($questionID, $answer){
		if($this->permission){
			$this->info['questionsLeft'] = $this->info['questionsLeft']-1;
			if($this->info['questionsLeft'] == 0){
				$this->setUserPermission();
			}
			$db = new DBManager();
			//update na poeni i se namaluva brojot na preostanati prasanja
			$err = $db->updatePoints($this->info['fbid'], $questionID, $this->info['questionsLeft'], $answer);
			$db->CloseConnection();
			
			if($err === FALSE){//ima greska
				return FALSE;
			}
			else{//nema greska
				return TRUE;
			}
		}
		else{
			return FALSE;
		}
		
	}
	
	public function getNextQuestion(){
		$db = new DBManager();
		$question=null;
		$result = $db->getUnfinishedQuestion('124324');
		if($result==false){
		
			$question=$db->getRandQuestion('124324');
		}
		else $question=$result;
		
		$db->CloseConnection();
		$q=new Question($question);
		echo $q->render('design/index.html');
	}
	
	public function validateAnswer($fbid,$questionId,$answer){
		$db=new DBManager();
		$db->validateAnswer($questionId,$answer,$fbid);
	}
	
	public function renderUserInfoForm($html_location){
		 $html = new simple_html_dom();
		 $html->load_file($html_location);
		 print $html->outertext;
	}
	
}//end class User

