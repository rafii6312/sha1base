<?php

class sha1base_location extends sha1base
{
	public $geoRequire = array();
	
	public function __construct()
	{

	}
	
	function getIP()
	{
		$ip = null;
		if ( isset($_SERVER["REMOTE_ADDR"])) {
			$ip = $_SERVER["REMOTE_ADDR"];
		} else if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
			$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		} else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
			$ip = $_SERVER["HTTP_CLIENT_IP"];
		}
		return $ip;
	}
	
	function setGeoRequire($arg)
	{
		if(is_array($arg) AND count($arg) == 2)
		{
			$this->geoRequire[$arg[0]] = $arg[1];
		} else {
			echo 'Invalid number of supplied argumends as array:<br>';
			echo '1 module name<br>';
			echo '2 path/file<br>';
			echo 'Files: geoip.inc, geoipcity.inc, geoipregionvars.php, timezone.php<br>';
		}
	}
	
	function loadGeoIP()
	{
		include_once($this->geoRequire['geoip.inc']);
		include_once($this->geoRequire['geoipcity.inc']);
		include_once($this->geoRequire['geoipregionvars.php']);
		include_once($this->geoRequire['timezone.php']);
	}
	
	public function getLocation($ip)
	{
		$this->loadGeoIP();
		$gi = geoip_open($this->geoRequire['geoipcity.dat'],GEOIP_STANDARD);
		$record = GeoIP_record_by_addr($gi, $ip );
		geoip_close($gi);
		return $record;
	}
}

?>
