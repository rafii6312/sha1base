<?php

class sha1base_filesystem extends sha1base
{
	public $filesFolder = '../../files/';
	public $importFolder = '../../files_import/';
	public $namesFolder = '../../files_names/';	
	
	public function __construct()
	{

	}
	
	public function addFile($file)
	{
		if(file_exists($this->importFolder . $file))
		{
			$hash = @sha1_file($this->importFolder . $file);
			if ($this->hashExists($hash) != true)
			{
				if(rename($this->importFolder . $file, $this->filesFolder . $hash))
				{
					file_put_contents($this->namesFolder . $hash, $file);
					return 4;
				} else {
					return 3;
				}
			} else {
				unlink($this->importFolder . $file);
				return 2;
			}
		} else {
			return 1;
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
		if(file_exists($this->namesFolder . $hash))
		{
			
		}
		return 'temp_name';
	}
}

?>
