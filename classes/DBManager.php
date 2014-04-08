<?php

class DBManager
{
	private $host = '127.0.0.1';
	private $username = 'root';
	private $pass = '';
	private $database = 'usersdb';
	private $mysqli;
	private $port;
	
	function connect()
	{
		$this->mysqli= new mysqli($this->host, $this->username, $this->pass, $this->database) or die();
		if ($this->mysqli->connect_errno) {
			echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}
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
		$query = $this->mysqli->query("SELECT * FROM user WHERE fbid=".$fbid."");
		$res = $query->fetch_assoc();
		return $res;
	}
	
	function addUser($fbid, $name, $email){
		$query = $this->mysqli->query("INSERT INTO user(fbid, name, email, quiz, points) VALUES(".$fbid.", '".$name."', '".$email."', 0, 0)");
		return $query;
	}
}