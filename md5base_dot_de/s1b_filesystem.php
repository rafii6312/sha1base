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
	
	function splitFile($att)
	{
		if(!is_array($att))
		{
			return false;
		}
		if(count($att) == 3)
		{
			$inputFile = $att[0];
			$outputFolder = $att[1];
			$piecesize = $att[2];
			$splitFiles = array();
			
			if(file_exists($inputFile))
			{
				$buffer = 1024;
				$piece = $piecesize;
				$current = 0;
				$splitnum = 1;
				
				if(!$handle = fopen($inputFile, "rb")) {
					return false;
				}
			
				$base_filename = basename($inputFile);
				$piece_name = $outputFolder.$base_filename.'.'.str_pad($splitnum, 3, "0", STR_PAD_LEFT);
				array_push($splitFiles, $piece_name);
				if($fw = fopen($piece_name,"w")){
					
					while (!feof($handle) and $splitnum < 999) {
						if($current < $piece) {
							if($content = fread($handle, $buffer)) {
								if(fwrite($fw, $content)) {
									$current += $buffer;
								} else {
									return false;
								}
							}
						} else {
							fclose($fw);
							$current = 0;
							$splitnum++;
							$piece_name = $outputFolder.$base_filename.'.'.str_pad($splitnum, 3, "0", STR_PAD_LEFT);
							array_push($splitFiles, $piece_name);
							$fw = fopen($piece_name,"w");
						}
					}
					fclose($fw);
					fclose($handle);
					
					return $splitFiles;
				} else {
					return false;
				}
			} else {
				return false;
			}			
		} else {
			return false;
		}
	}
	
	function mergeFile($att)
	{
		if(!is_array($att))
		{
			return false;
		}
		if(count($att) == 2)
		{
			$inputFiles = $att[0];
			$outputFile = $att[1];
			
			
		}
	}
	
	public function hashExists($hash)
	{
		$hash_exists = false;
		if ($handle = opendir($this->filesFolder))
		{
			while (false !== ($file = readdir($handle)))
			{
				if ($file != "." && $file != "..")
				{
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
		$fname = 'unknown';
		if(file_exists($this->namesFolder . $hash))
		{
			$fname = @file_get_contents($this->namesFolder . $hash);
		}
		return $fname;
	}
	
	public function readFile($file)
	{
		if(file_exists($this->filesFolder . $file))
		{
			return base64_encode(file_get_contents($this->filesFolder . $file));
		}
		return false;
	}
}

?>
