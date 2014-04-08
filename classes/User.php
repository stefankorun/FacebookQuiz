<?php
require_once 'DBManager.php';

class User{
	private $info = array();//info za user
	private $permission; //0 - ne smejt da go prajt kvizot, 1 - smejt
	private static $max_questions = 10;
	
	function __construct($fbid, $name, $email, $tel){
		$db_user_info = $this->getUserInfo($fbid);
		if($db_user_info != NULL){
			$this->setUserInfo($db_user_info);
			$this->setUserPermission();
		}
		else{
			$this->addUser($fbid, $name, $email, $tel);
			$this->permission = 1;
		}
	}
	
	//private functions...

	//postavuvanje permisii za dali smejt ili ne da prajt kviz
	private function setUserPermission(){
		if(($this->info['questionsLeft'] > 0)){
			$this->permission = 1;
		}
		else{
			$this->permission = 0;
		}
	}
	
	//zema info za user od baza
	private function getUserInfo($fbid){
		$result = array();
		$db = new DBManager();
		$result = $db->getUserByFbid($fbid);
		$db->CloseConnection();
		
		if($result === TRUE){//korisnikot ne e vnesen vo bazata
			return NULL;
		}
		else
			return $result;
	}
	
	//populnuvanje info za user
	private function setUserInfo($db_user_info){
		$this->info = array(
				"fbid" => $db_user_info['fb_id'], 	//id od facebook
				"name" => $db_user_info['name'], 	//fb ime
				"email" => $db_user_info['email'], 	//email so trebit sam da go vnesit
				"tel" => $db_user_info['tel'],
				"questionsLeft" => $db_user_info['questionsLeft'], 	// 0 - ne go imat napraeno, 1 - go imat napraeno
				"points" => $db_user_info['points'] // poeni od kvizot
		);
	}
	
	//dodava user vo baza
	private function addUser($fbid, $name, $email, $tel){
		$db = new DBManager();
		$err = $db->addUser($fbid, $name, $email, $tel);
		$db->CloseConnection();
		
		if($err){//ima greska
			return TRUE;
		}
		else{//nema greska
			return FALSE;
		}
	}
	
	//end private functions...
	
	//public functions...
	
	//provervis dali smejt da go prajt kvizot ili ne
	public function getPermission(){
		return $this->permission;
	}
	
	//vrakjat info za user
	public function getInfo(){
		return $this->info;
	}
	
	//nov odgovor na prasanje so id X
	public function newAnswer($questionID, $answer){
		$this->info['questionsLeft'] = $this->info['questionsLeft']-1;
		if($this->info['questionsLeft'] == 0){
			$this->setUserPermission();
		}
		$db = new DBManager();
		//update na poeni i se namaluva brojot na preostanati prasanja
		$err = $db->updatePoints($this->info['fbid'], $questionID, $this->info['questionsLeft'], $answer);
		$db->CloseConnection();
		
		if($err){//ima greska
			return TRUE;
		}
		else{//nema greska
			return FALSE;
		}
	}
	
	//end public functions...
	
}//end class User

$user = new User(110, "Hristijan k", "hr@hotmail.com", "077123123");
//print_r($user->getInfo());
//echo $user->getPermission();
$user->newAnswer(1, 3);
