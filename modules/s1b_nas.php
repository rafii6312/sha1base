<?php

class sha1base_nas extends sha1base
{
	public $loginRequired = false;
	public $database = 'database.db';
	public $databaseHandle = null;
	
	public function __construct()
	{
		
	}
	
	public function init()
	{
		$this->databaseHandle = new PDO('sqlite:' . $this->database);
	}
	
	public function login($arg)
	{
		if($this->loginRequired == false) return true;
		
	}
	
	public function getFiles()
	{
		$files = array();
		foreach($this->databaseHandle->query('SELECT * FROM files') as $row)
		{
			array_push($files, $row);
		}
		return $files;
	}
	
	public function getFilename($hash)
	{
		foreach($this->databaseHandle->query("SELECT * FROM files WHERE sha1 = '$hash'") as $row)
		{
			return $row['filename'];
		}
		return 'unknown';
	}
	
	public function getFilesize($hash)
	{
		foreach($this->databaseHandle->query("SELECT * FROM files WHERE sha1 = '$hash'") as $row)
		{
			return $row['size'];
		}
		return '0';
	}
	
	public function getCategories()
	{
		$out = array();
		foreach($this->databaseHandle->query("SELECT * FROM categories") as $row)
		{
			array_push($out, $row);
		}
		return $out;
	}
	
	public function getSubCategories()
	{
		$out = array();
		foreach($this->databaseHandle->query("SELECT * FROM subCategories") as $row)
		{
			array_push($out, $row);
		}
		return $out;
	}
	
	public function getServer($hash)
	{
		foreach($this->databaseHandle->query("SELECT files.sha1, servers.serverId, servers.root FROM files INNER JOIN servers ON servers.serverId=files.serverId WHERE sha1='$hash'") as $row)
		{
			return $row['root'];
		}
		return 'unknown';
	}
	
	public function addFile($args)
	{
		$this->databaseHandle->query("
		INSERT INTO files
		(
			typeId, catId, subCatId, serverId, filename, sha1, md5, size
		) VALUES (
			'0', '0', '0', '$args[4]', '$args[0]', '$args[1]', '$args[2]', '$args[3]' 
		);
		");
		//print_r($this->databaseHandle->errorInfo());
	}
	/*
	public function removeFile($hash)
	{
		$this->databaseHandle->query("DELETE FROM files WHERE sha1 = '$hash'");
		if(file_exists($this->getServer($hash) . $hash)) unlink($this->getServer($hash) . $hash);
	}
	*/
}

?>
