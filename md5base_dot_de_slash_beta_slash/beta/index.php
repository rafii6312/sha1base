<?php
error_reporting(E_ALL);
include_once('s1b_core.php');
include_once('config.php');
$m = new sha1base();
$m->loadModule('s1b_filesystem', 'sha1base_filesystem');
$m->loadModule('s1b_network', 'sha1base_network');
$m->loadModule('s1b_media', 'sha1base_media');
$m->loadModule('s1b_encrypt', 'sha1base_encrypt');

//for($i = 1; $i <= 300; $i++){ echo $i . ') ' . strlen($m->cEF('sha1base_encrypt', 'encrypt', $m->cEF('sha1base_encrypt', 'randomString', $i))) . '<br>'; }


?>
<html>
	<body>
		<div style="width:100%;"><br>
			<center><h3>Upload</h3>
				<form enctype="multipart/form-data" action="upload.php" method="POST">
					File: <input name="uploadedfile" type="file" /><input type="submit" value="Upload File" /><br>
					Password will be generated, <b>16 char alpha numeric</b> and <b>AES256</b> encryption (RIJNDAEL_256)<br>
					MAX filesize <?php echo $maxUploadSize / 1024 / 1024 ; ?> MB!
				</form>
			</center>
			<br>
		</div>
		<br>
		<div style="width:100%;"><br>
			<center><h3>Download</h3>
				<form enctype="multipart/form-data" action="decrypt.php" method="POST">
					ID: <input name="id"> Pass: <input name="pass"><input type="submit" value="Decrypt & download" />
				</form>
			</center>
			<br>
		</div>
	



<?php


$data = explode("\n", file_get_contents("/proc/meminfo"));
$meminfo = array();
foreach ($data as $line) {
 	@list($key, $val) = explode(":", $line);
 	$meminfo[$key] = trim($val);
}
echo 'MEM left/total: ' . round(str_replace(' kB' ,'',$meminfo['MemFree']) / 1024) . '/' . round(str_replace(' kB' ,'',$meminfo['MemTotal']) / 1024) . ' MB<br><br>';

/*
$fp = fopen('test.bmp', "r");
while (!feof($fp))
{
	$raw = fread($fp, 1024);
	echo 'input length: ' .strlen($raw) . '<br>output length: ' . strlen($m->cEF('sha1base_encrypt', 'encrypt', $raw)) . '<br><br>';
	
	break;
}
fclose($fp);
*/
?>

	</body>
</html>










