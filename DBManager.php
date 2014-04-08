<?php

class DBManager
{
	private $host = '127.0.0.1';
	private $username = 'root';
	private $pass = '';
	private $database = 'usersdb';
	
	function connect()
	{
		$link=mysql_connect($this->host,
				$this->username, $this->pass) or die();
		return $link;
	}
	
	function selectDB($link)
	{
		mysql_select_db($this->database,$link);
	}
	
	function CloseConnection()
	{
		mysql_close();
	}
	
	function __construct()
	{
		$link = $this->connect();
		$this->selectDB($link);
	}
	
	function getUserByFbid($fbid){
		$res = array();
		$query = mysql_query("SELECT * FROM user WHERE fbid=".$fbid."");
		while($row=mysql_fetch_assoc($query))
		{
			array_push($res,$row);
			
		}
		return $res;
	}
	
	function addUser($fbid, $name, $email){
		$query = mysql_query("INSERT INTO user(fbid, name, email, quiz, points) VALUES(".$fbid.", '".$name."', '".$email."', 0, 0)");
		return $query;
	}
}