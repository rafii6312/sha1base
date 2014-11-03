<?php

include_once('s1b_core.php');
include_once('config.php');
error_reporting(E_ALL);
$m = new sha1base();
$m->loadModule('s1b_filesystem', 'sha1base_filesystem');
$m->loadModule('s1b_network', 'sha1base_network');
$m->loadModule('s1b_media', 'sha1base_media');
$m->loadModule('s1b_encrypt', 'sha1base_encrypt');
$m->loadModule('s1b_login', 'sha1base_login');
$m->loadModule('s1b_sqlite', 'sha1base_sqlite');

$m->cEF('sha1base_sqlite', 'loadDb', '../logging/stats.db');


date_default_timezone_set('UTC');
$stats = $m->cEF('sha1base_sqlite', 'query', "SELECT * FROM stats_vs");
$dayStats = array();
$dA = array();
foreach($stats as $stat)
{
	$tmp = date('z.o', $stat[1]);
	array_push($dayStats, $tmp);
	array_push($dA, $stat[1]);
}

/*
foreach($dayStats as $dayStat)
{
	echo $dayStat . '<br>';
}
*/

echo '<div style="height:100px; width:356px; position: relative; border:1px solid black;">';
$left = 0;
$wid = 1;
$i = 0;

/*
foreach(array_count_values($dayStats) as $dayStat)
{
	for($i = 1; $i <= 356; $i++)
	{
		if(isset($dA[$i]))
		{
			if($i == date('z', $dA[$i]))
			{
				echo '<div style="float:left; position: absolute; bottom: 0; left:' . $left . '; background-color:red; width:' . $wid . 'px; height:' . $dayStat . ';"></div>';
			} else {
				echo '<div style="float:left; position: absolute; bottom: 0; left:' . $left . 'px; background-color:black; width:' . $wid . 'px; height:100px;"></div>';
			}
		} else {
			echo '<div style="float:left; position: absolute; bottom: 0; left:' . $left . 'px; background-color:black; width:' . $wid . 'px; height:100px;"></div>';
		}
		$left = $left + $wid;
	}
	$i++;
}
echo '</div>';
*/






for($i = 1; $i <= 356; $i++)
{
	
}

































?>