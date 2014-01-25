<?php
//error_reporting(E_ALL);

class sha1base_mysqli extends sha1base
{
	public $mysqli_db = array();
	
	public function __construct()
	{
		
	}
	
	public function connect($args)
	{
		if(count($args) != 6 OR is_array($args) == false)
		{
			echo 'wrong supply of arguments<br>';
			echo 'Args as array:<br>';
			echo '1 association<br>';
			echo '2 host<br>';
			echo '3 port<br>';
			echo '4 user<br>';
			echo '5 pass<br>';
			echo '6 database<br>';
			exit;
		} else {
			$this->mysqli_db[$args[0]] = @mysqli_connect($args[1], $args[3], $args[4], $args[5], $args[2]);
			if ($this->mysqli_db[$args[0]]->connect_errno) {
				printf("Connect failed: %s\n", $this->mysqli_db[$args[0]]->connect_error);
				exit();
			}
		}
	}
	
	public function query($args)
	{
		if(is_array($args) AND count($args) == 2)
		{
			try
			{
				$res = mysqli_query($this->mysql_db[$args[0]], $args[1]);
				$out = array();
				while($row = mysqli_fetch_object($res))
				{
				  array_push($out, $row);
				}
				return $out;
			} catch (Exception $e)
			{
				return false;
			}
		} else {
			echo 'you have to supply 2 arguments as array:<br>';
			echo '1 connection association<br>';
			echo '2 query<br>';
		}
		
		
	}
}


?>
