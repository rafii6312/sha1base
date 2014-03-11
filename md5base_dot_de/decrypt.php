<?php

ignore_user_abort(TRUE);
include_once('s1b_core.php');
include_once('config.php');


$m = new sha1base();
$m->loadModule('s1b_filesystem', 'sha1base_filesystem');
$m->loadModule('s1b_network', 'sha1base_network');
$m->loadModule('s1b_media', 'sha1base_media');
$m->loadModule('s1b_encrypt', 'sha1base_encrypt');
$m->loadModule('s1b_sqlite', 'sha1base_sqlite');

if(isset($_POST['id']) AND isset($_POST['pass']))
{
	$id = preg_replace('/[^a-zA-Z0-9]/', "", $_POST['id']);
	$pass = preg_replace('/[^a-zA-Z0-9]/', "", $_POST['pass']);
	
	if(strlen($pass) < 1)
	{
		echo 'error, no pass was submit';
		exit;
	}

	$dec = $tempFolder . rand(1,10000000);
	$m->setExtVar('sha1base_encrypt', 'pass', ($pass));
	if(!$m->cEF('sha1base_encrypt', 'decrypt_file',array($filesFolder . $id, $dec)))
	{
		echo 'error while decrypting!';
		exit;
	}
	$m->cEF('sha1base_network', 'startDl', array($dec, $maxDownloadSpeed, 'file'));
	@unlink($dec);
} elseif(isset($_POST['fastdl']) OR isset($_GET['fastdl']))
{
	if(isset($_GET['fastdl'])) $fdl = base64_decode($_GET['fastdl']);
	if(isset($_POST['fastdl'])) $fdl = base64_decode($_POST['fastdl']);
	
	
	$fdlp = explode('|', $fdl);
	if(count($fdlp) == 3)
	{
		$id = $fdlp[0];
		$pass = $fdlp[1];
		$filename = $fdlp[2];
		
		$dec = $tempFolder . rand(1,10000000);
		$m->setExtVar('sha1base_encrypt', 'pass', ($pass));
		if(!$m->cEF('sha1base_encrypt', 'decrypt_file',array($filesFolder . preg_replace('/[^a-zA-Z0-9]/', "", $id), $dec)))
		{
			echo 'error while decrypting!';
			exit;
		}
		$t = time();
		$ip = $m->cEF('sha1base_network', 'getIp');
		$m->cEF('sha1base_sqlite', 'loadDb', '../logging/stats.db');
		$m->cEF('sha1base_sqlite', 'query', "INSERT INTO stats_dl (id, ip, date) VALUES ('$id', '$ip', '$t')");
		if(file_exists($dec)) $m->cEF('sha1base_network', 'startDl', array($dec, $maxDownloadSpeed, $filename));
		@unlink($dec);
		
		
	} else {
		echo 'invalid FastDL link!<br>';
		echo 'ID | PASS | FILENAME';
		exit;
	}
}

