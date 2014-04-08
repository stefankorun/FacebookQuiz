<?php
require_once 'DBManager.php';

class User{
	private $info = array();//info za user
	private $permission; //0 - ne smejt da go prajt kvizot, 1 - smejt
	private static $max_questions = 20;
	
	function __construct($fbid, $name, $email){
		$db_user_info = $this->getUserInfo($fbid);
		if($db_user_info != NULL){
			$this->setUserInfo($db_user_info);
			$this->setUserPermission();
		}
		else{
			$this->addUser($fbid, $name, $email);
			$this->permission = 1;
		}
	}
	
	//private functions...

	//postavuvanje permisii za dali smejt ili ne da prajt kviz
	private function setUserPermission(){
		if(($this->info['id'] == '') || ($this->info['quiz'] == 0)){
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
		
		if(sizeof($result) == 0){//korisnikot ne e vnesen vo bazata
			return NULL;
		}
		return $result[0];
	}
	
	//populnuvanje info za user
	private function setUserInfo($db_user_info){
		$this->info = array(
				"id" => $db_user_info['id'],
				"fbid" => $db_user_info['fbid'], 	//id od facebook
				"name" => $db_user_info['name'], 	//fb ime
				"email" => $db_user_info['email'], 	//email so trebit sam da go vnesit
				"quiz" => $db_user_info['quiz'], 	// 0 - ne go imat napraeno, 1 - go imat napraeno
				"points" => $db_user_info['points'] // poeni od kvizot
		);
	}
	
	//dodava user vo baza
	private function addUser($fbid, $name, $email){
		$db = new DBManager();
		$db->addUser($fbid, $name, $email);
		$db->CloseConnection();
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
	
	public function quizComplete(){
		$this->info['quiz'] = 1;
		//update vo baza
		return TRUE;
	}
	
	//end public functions...
	
}//end class User

$user = new User(10, "Kasper k", "kasper@hotmail.com");
print_r($user->getInfo());
echo $user->getPermission();
