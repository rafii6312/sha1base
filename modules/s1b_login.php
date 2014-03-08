<?php

class sha1base_login extends sha1base
{
	
	public function __construct()
	{
		
	}
	
	public function login($arg)
	{
		if(!is_array($arg))
		{
			@session_start();
			if(true) {
				$_SESSION['s1blogin'] = true;
				$_SESSION['s1buser'] = $arg;
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function isLoggedIn()
	{
		@session_start();
		$li = true;
		if (!isset($_SESSION['s1blogin']) || !$_SESSION['s1blogin']) {
			$li = false;
		}
		return $li;
	}
	
	public function getUser()
	{
		if($this->isLoggedIn())
		{
			return $_SESSION['s1buser'];
		} else {
			return false;
		}
	}
	
	public function logout()
	{
		@session_start();
		@session_destroy();
	}
	
	function sql_login($args)
	{
		if(is_array($args) AND count($args) == 2)
		{
			return "SELECT username FROM userdata WHERE username = '$args[0]' AND pass = '$args[1]' LIMIT 1";
		}
	}
	
	function sql_register($args)
	{
		if(is_array($args) AND count($args) == 3)
		{
			return "INSERT INTO userdata (username, email, pass) VALUES ('$args[0]', '$args[2]','$args[1]')";
		}
	}
	
	function sql_exists($args)
	{
		if(is_array($args) AND count($args) == 2)
		{
			return "SELECT username FROM userdata WHERE username = '$args[0]' AND pass = '$args[1]' LIMIT 1";
		}
	}
}

?>
