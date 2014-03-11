<?php

class sha1base_network extends sha1base
{
	public $maxDl; //max download speed in B/s
	public $maxUploadSize; //max upload size in bytes

	public function __construct()
	{

	}
	
	public function ping($host)
	{
		$starttime = microtime(true);
		$file      = @fsockopen (parse_url($host, PHP_URL_HOST), 80, $errno, $errstr, 10);
		$stoptime  = microtime(true);
		$status    = 0;

		if (!$file) $status = false;
		else {
			fclose($file);
			$status = ($stoptime - $starttime) * 1000;
			$status = floor($status);
		}
		return $status;
	}
	
	
	public function startDl($att)
	{
		if(file_exists($att[0]) AND ($att[0] != ''))
		{
			// 0) filename
			// 1) speed in byte/sec
			// 2) name shown
			//$name = $this->callExtFunction('sha1base_filesystem', 'getName', $att[0]);
			$name = $att[2];
			$type = $this->callExtFunction('sha1base_media', 'mime_content_type', $att[0]);
			header("Content-Type: $type");
			header("Content-Disposition: attachment; filename=\"$name\"");
			header("Content-Length: " . filesize($att[0]));
			
			$fp = fopen($att[0], "r");
			$this->callOnDownloadStart($att[0]);
			if($att[1] != 0)
			{
				$sleepTime = (65536 * 1000000) / ($att[1]);
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
			$this->callOnDownloadFinish($att[0], 1);
			return true;
		} else {
			$this->callOnDownloadFinish($att[0], 2);
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
	
	function getIp()
	{
		$ip = '0.0.0.0';
		if ( isset($_SERVER["REMOTE_ADDR"]) )    {
			$ip = $_SERVER["REMOTE_ADDR"];
		} elseif ( isset($_SERVER["HTTP_X_FORWARDED_FOR"]) )    {
			$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		} elseif ( isset($_SERVER["HTTP_CLIENT_IP"]) )    {
			$ip = $_SERVER["HTTP_CLIENT_IP"];
		}
		return $ip;
	}
}


?>
