<?php
error_reporting(E_ALL);

class sha1base_mysql extends sha1base
{
	public $mysql_db = null;
	
	public $version = '0.1';
	public $build = '1';
	public $stable = false;
	
	public function __construct()
	{
		
	}
	
	public function connect($args)
	{
		try
		{
			if(count($args) == 3)
			{
				$this->mysql_db = mysql_connect($args[0], $args[1], $args[2]);
				return true;
			} else {
				return false;
			}
		} catch (Exception $e)
		{
			return false;
		}
	}
	
	public function query($arg)
	{
		try
		{
			$res = mysql_query($this->mysql_db, $arg);
			$out = array();
			while($row = mysql_fetch_object($res))
			{
			  array_push($out, $row);
			}
			return $out;
		} catch (Exception $e)
		{
			return false;
		}
	}
}


?>
