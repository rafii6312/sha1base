<?php

include_once('s1b_core.php');
include_once('config.php');
$m = new sha1base();
$m->loadModule('s1b_filesystem', 'sha1base_filesystem');
$m->loadModule('s1b_network', 'sha1base_network');
$m->loadModule('s1b_media', 'sha1base_media');
$m->loadModule('s1b_encrypt', 'sha1base_encrypt');


$pass = $m->cEF('sha1base_encrypt', 'randomString', '16');
//$m->cEF('sha1base_encrypt', 'setPass', $pass);
$m->setExtVar('sha1base_encrypt', 'pass', $pass);


$source_path = $tempFolder . rand(1,100000);
$destination_path = $filesFolder . rand(1,10000);


if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $source_path)) {
	$ufsize = filesize($source_path);
	if($ufsize >= $maxUploadSize)
	{
		echo 'Sorry, your file was too big<br>';
		echo 'Max filesize is ' . $maxUploadSize . ', your files was ' . $ufsize;
		@unlink($source_path);
		exit;
	}
	
	if($m->cEF('sha1base_encrypt', 'encrypt_file', array($source_path, $destination_path)))
	{	
		$hash = sha1($destination_path);
		
		if(file_exists($filesFolder . $hash))
		{
			unlink($filesFolder . $hash);
		}
		
		rename($destination_path, $filesFolder . $hash);
		
		$filename = str_replace('|', '', $_FILES['uploadedfile']['name']);
		$filename = str_replace('$', '', $filename);
		
		echo $hash . '$' . $pass . '$' . base64_encode($hash . '|' . $pass . '|' . $filename); 
		
		
	} else {
		'Failed while encrypting';
	}
} else{
	if(file_exists($source_path)) unlink($source_path);
    echo 'Failed while uploading';
}


?>