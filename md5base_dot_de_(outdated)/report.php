<?php

include_once('s1b_core.php');
include_once('config.php');
$m = new sha1base();
$m->loadModule('s1b_filesystem', 'sha1base_filesystem');
$m->loadModule('s1b_network', 'sha1base_network');
$m->loadModule('s1b_media', 'sha1base_media');
$m->loadModule('s1b_encrypt', 'sha1base_encrypt');
$m->loadModule('s1b_sqlite', 'sha1base_sqlite');


$ip = $m->cEF('sha1base_network', 'getIp');
$t = time();
$m->cEF('sha1base_sqlite', 'loadDb', '../logging/stats.db');


if(isset($_POST['id']) AND isset($_POST['pass']) AND isset($_POST['fastdl']) AND isset($_POST['reason']))
{
	$id = $_POST['id'];
	$pass = $_POST['pass'];
	$fastdl = $_POST['fastdl'];
	$reason = $_POST['reason'];
	$comment = '';
	if(isset($_POST['comment'])) $comment = $_POST['comment'];
	
	$m->callExtFunction('sha1base_sqlite', 'query', "INSERT INTO stats_rp (id, pass, fastdl, reason, comment, ip, date) VALUES ('$id', '$pass', '$fastdl', '$reason', '$comment', '$ip', '$t')");
	
} else {
	$stats = $m->cEF('sha1base_sqlite', 'query', "SELECT * FROM stats_rp");
	foreach($stats as $stat)
	{
		echo $stat[0] . '<br>';
	}
}



?>