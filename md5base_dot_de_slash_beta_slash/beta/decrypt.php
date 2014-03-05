<?php
error_reporting(E_ALL);
include_once('s1b_core.php');
$m = new sha1base();
$m->loadModule('s1b_mysql', 'sha1base_mysql');
$m->loadModule('s1b_mysqli', 'sha1base_mysqli');
$m->loadModule('s1b_sqlite', 'sha1base_sqlite');
$m->loadModule('s1b_filesystem', 'sha1base_filesystem');
$m->loadModule('s1b_network', 'sha1base_network');
$m->loadModule('s1b_media', 'sha1base_media');
$m->loadModule('s1b_location', 'sha1base_location');
$m->loadModule('s1b_encrypt', 'sha1base_encrypt');

$filesFolder = '../../files/';
$tempFolder = '../../temp/';

if(isset($_POST['id']) AND isset($_POST['pass']))
{
	$dec = $tempFolder . rand(1,100000);
	$m->setExtVar('sha1base_encrypt', 'pass', ($_POST['pass']));
	if(!$m->cEF('sha1base_encrypt', 'decrypt_file',array($filesFolder . preg_replace('/[^a-zA-Z0-9]/', "", $_POST['id']), $dec)))
	{
		echo 'error while decrypting!';
		exit;
	}
	$m->cEF('sha1base_network', 'startDl', array($dec, 8 * 1024 * 1024, 'abc'));
	unlink($dec);
}

