<?php
error_reporting(E_ALL);

class sha1base_mysql extends sha1base
{
	public $mysql_db = null;
	
	public function __construct()
	{
		
	}
	
	public function connect($args)
	{
		try
		{
			$this->mysql_db = mysql_connect($args[0], $args[1], $args[2], $args[3]) or die("Error " . mysql_error($this->mysql_db));
			return true;
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
