<?php
error_reporting(E_ALL);

class sha1base_sqlite extends sha1base
{
	public $sqlite_db;
	
	public function __construct()
	{
		
	}
	
	public function loadDb($dbfile)
	{
		try
		{
			if(file_exists($dbfile))
			{
				$this->sqlite_db = new SQLite3($dbfile);
				return true;
			} else {
				return false;
			}
		} catch(Exception $e)
		{
			return false;
		}
	}
	
	public function query($arg)
	{
		$res = $this->sqlite_db->query($arg);
		$out = array();
		while($row = $res->fetchArray())
		{
			array_push($out, $row);
		}
		return $out;
	}
}



?>
