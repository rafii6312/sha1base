<?php

class sha1base_network extends sha1base
{
	public $maxDl; //max download speed in B/s
	public $maxUploadSize; //max upload size in bytes
	public $filesFolder;
	public $namesFolder;
	
	public function __construct()
	{

	}
	
	public function ping($host)
	{
		$starttime = microtime(true);
		$file      = @fsockopen (parse_url($host, PHP_URL_HOST), 80, $errno, $errstr, 10);
		$stoptime  = microtime(true);
		$status    = 0;

		if (!$file) $status = 999;
		else {
			fclose($file);
			$status = ($stoptime - $starttime) * 1000;
			$status = floor($status);
		}
		return $status;
	}
	
	
	public function startDl($att)
	{
		if(file_exists($this->filesFolder . $att[0]) AND ($att[0] != ''))
		{
			//$name = $this->callExtFunction('sha1base_filesystem', 'getName', $att[0]);
			$name = $att[2];
			$type = $this->callExtFunction('sha1base_media', 'mime_content_type', $this->filesFolder . $att[0]);
			header("Content-Type: $type");
			header("Content-Disposition: attachment; filename=\"$name\"");
			header("Content-Length: " . filesize($this->filesFolder . $att[0]));
			
			$fp = fopen($this->filesFolder . $att[0], "r");
			$this->callOnDownloadStart($att[0]);
			if($att[1] != 0)
			{
				$sleepTime = (65536 * 1000000) / ($att[2]);
			} else {
				$sleepTime = (65536 * 1000000) / ($this->maxDl);
			}
			while (!feof($fp))
			{
				echo fread($fp, 65536); //64kb parts
				flush();
				usleep($sleepTime); //wait after each 64kb. 2000000 = 2 sec
				$this->callOnDownloadChunk($att[0]);
			}
			fclose($fp);
			$this->callOnDownloadFinish($hash, 1);
			return true;
		} else {
			$this->callOnDownloadFinish($hash, 2);
			return false;
		}
	}
	
	function callOnDownloadChunk($hash)
	{
		
	}
	
	function callOnDownloadStart($hash)
	{
	
	}
	
	function callOnDownloadFinish($hash, $status)
	{
		
	}
}


?>
