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


$pass = $m->cEF('sha1base_encrypt', 'randomString', '16');
$m->setExtVar('sha1base_encrypt', 'pass', $pass);

$filesFolder = '../../files/';
$tempFolder = '../../temp/';
$source_path = $tempFolder . rand(1,100000);
$destination_path = $filesFolder . rand(1,10000);


if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $source_path)) {
	if($m->cEF('sha1base_encrypt', 'encrypt_file', array($source_path, $destination_path)))
	{
		$hash = sha1($destination_path);
		
		if(file_exists($filesFolder . $hash))
		{
			unlink('files/' . $hash);
		}
		rename($destination_path, $filesFolder . $hash);
		
		echo 'ID: ' . $hash . '<br>';
		echo 'Password: ' .$pass . '<br>';
		echo 'Please note/copy <b>BOTH</b>, case sensitive!';
	} else {
		'Failed while encrypting';
	}
} else{
	unlink($source_path);
    echo 'Failed while uploading';
}


?>