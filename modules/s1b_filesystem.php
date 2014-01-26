<?php

class sha1base_filesystem extends sha1base
{
	public $filesFolder = '../../files/';
	public $namesFolder = '../../files_names/';	
	
	public function __construct()
	{

	}
	
	public function addFile($file)
	{
		//1) import sucessful
		//2) copying failed
		//3) file did exist
		//4) import file did not exist
		if(file_exists($file))
		{
			$hash = @sha1_file($file);
			if ($this->hashExists($hash) != true)
			{
				if(rename($file, $this->filesFolder . $hash))
				{
					file_put_contents($this->namesFolder . $hash, basename($file));
					return array(1, $hash);
				} else {
					return array(3, 'copying failed');
				}
			} else {
				unlink($file);
				return array(2, $hash);
			}
		} else {
			return array(4, 'file not found');
		}
	}
	
	public function hashExists($hash)
	{
		$hash_exists = false;
		if ($handle = opendir($this->filesFolder))
		{
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != "..") {
					if ($file == $hash)
					{
						$hash_exists = true;
					}
				}
			}
			closedir($handle);
		}
		return $hash_exists;
	}
	
	public function getName($hash)
	{
		$fname = 'unkown';
		if(file_exists($this->namesFolder . $hash))
		{
			$fname = @file_get_contents($this->namesFolder . $hash);
		}
		return $fname;
	}
}

?>
