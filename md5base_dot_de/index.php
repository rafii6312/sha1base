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

$mobileView = false;
if(preg_match('/(alcatel|amoi|android|avantgo|blackberry|benq|cell|cricket|docomo|elaine|htc|iemobile|iphone|ipad|ipaq|ipod|j2me|java|midp|mini|mmp|mobi|motorola|nec-|nokia|palm|panasonic|philips|phone|sagem|sharp|sie-|smartphone|sony|symbian|t-mobile|telus|up\.browser|up\.link|vodafone|wap|webos|wireless|xda|xoom|zte)/i', $_SERVER['HTTP_USER_AGENT']))
    $mobileView = true;

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
	<head>
		<title>MD5BASE - RELOADED</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<script type="text/javascript">
			function a()
			{
				document.getElementById('formUp').style.display = "block";
				document.getElementById('formDown').style.display = "none";
				document.getElementById('formFastDl').style.display = "none";
			}
			function b()
			{
				document.getElementById('formUp').style.display = "none";
				document.getElementById('formDown').style.display = "block";
				document.getElementById('formFastDl').style.display = "none";
			}
			function c()
			{
				document.getElementById('formUp').style.display = "none";
				document.getElementById('formDown').style.display = "none";
				document.getElementById('formFastDl').style.display = "block";
			}
			
			function _(el)
			{
				return document.getElementById(el);
			} 
			
			function uploadFile()
			{ 
				var file = _("file").files[0]; 
				//alert(file.name+" | "+file.size+" | "+file.type); 
				var formdata = new FormData(); 
				formdata.append("uploadedfile", file); 
				var ajax = new XMLHttpRequest(); 
				ajax.upload.addEventListener("progress", progressHandler, false); 
				ajax.addEventListener("load", completeHandler, false); 
				ajax.addEventListener("error", errorHandler, false);
				ajax.addEventListener("abort", abortHandler, false);
				ajax.open("POST", "upload.php"); 
				ajax.send(formdata);
				_("form-container-upload-pgb").style.display = "block";
				_("form-container-upload-info").style.display = "none";
			 }
			 
			 /*
			 function downloadFile()
			 {
				var formdata = new FormData(); 
				var id = _("downId");
				var pass = _("downPass");
			 }
			 */
			 
			 function progressHandler(event){
				 var percent = (event.loaded / event.total) * 100;
				 _("status").innerHTML = Math.round(percent)+"% uploaded...";
				 _("pgb").style.width = Math.round((percent)) + "%";
			 } 
			 function completeHandler(event){
				var resp = event.target.responseText;
				var respx = resp.split("$");
				if(respx.length == 3)
				{
					_("status").innerHTML = "Upload finished.";
					_("id").innerHTML = respx[0];
					_("pass").innerHTML = respx[1];
					_("fastdl").innerHTML = respx[2];
				} else {
					_("status").innerHTML = resp;
				}
				
				_("form-container-upload-pgb").style.display = "none";
				_("form-container-upload-info").style.display = "block";
			 }
			 function errorHandler(event){
			 _("status").innerHTML = "Upload Failed";
			 } 
			 function abortHandler(event){
			 _("status").innerHTML = "Upload Aborted";
			 }
			function viewPage()
			{
				_("everything").style.display = "block";
				_("nojs").style.display = "none";
			}
			
		</script>
		<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
		<script type="text/javascript" src="js/jquery.form.min.js"></script>
	</head>
	<body onload="viewPage()">
		<div id="everything" style="display:none;">
			<form class="form-container-control form-container-main <?php if($mobileView) echo 'form-container-main-mobile'; ?>">
				<div class="form-title"><h3>MD5-BASE</h3></div>
				<div style="text-align:center;">
					<img alt="file upload" src="img/up.png" onclick="a()" class="btns">
					<img alt="file download" src="img/down.png" onclick="b()" class="btns">
					<img alt="file download via FastDL" onclick="c()" src="img/fastdl.png" class="btns">
				</div>
			</form>
			
			<br>
			
				<form id="formUp" class="form-container-upload form-container-main <?php if($mobileView) echo 'form-container-main-mobile'; ?>" enctype="multipart/form-data" action="upload.php" method="POST">
				<div class="form-title"><h2>Upload</h2></div>
				<div class="form-title">File</div>
					<input class="form-field-upload" type="file" id="file" name="uploadedfile" /><br />
				<div id="form-container-upload-pgb" class="form-container-upload-pgb">
					<div id="pgb" class="form-container-upload-pgb-inner">
					</div>
				</div>
				<small id="status"></small>
					<div class="form-container-upload-info" id="form-container-upload-info">
						<br><br>
						<small>ID:<br><small id="id">...</small><br>
						Pass:<br><small id="pass">...</small><br>
						FastDL:<br><small id="fastdl">...</small></small><br><br>
					</div>
				<br>
					<small>Password will be generated, 16 char alpha numeric and AES256 encryption. MAX filesize <?php echo $maxUploadSize / 1024 / 1024 ; ?> MB!</small>
				<div class="submit-container">
					<input class="submit-button" type="button" onclick="uploadFile()" value="Submit" />
				</div>
				</form>

				<form id="formDown"  class="form-container-dl form-container-main <?php if($mobileView) echo 'form-container-main-mobile'; ?>" enctype="multipart/form-data" action="decrypt.php" method="POST">
				<div class="form-title"><h2>Download</h2></div>
				<div class="form-title">File ID</div>
					<input class="form-field" type="text" id="downId" name="id" /><br />
				<div class="form-title">Pass</div>
				<input class="form-field" type="text" id="downPass" name="pass" /><br />
				
					<small>Download do start, even if your pass is wrong (but file is junk)! There is no way to check if 
					a file is valid without	additional logging, which i dont want.</small>
					<div class="submit-container">
				<input class="submit-button" type="submit" value="Submit" />
				</div>
				</form>
				
				<form id="formFastDl" class="form-container-fastdl form-container-main <?php if($mobileView) echo 'form-container-main-mobile'; ?>" enctype="multipart/form-data" action="decrypt.php" method="POST">
				<div class="form-title"><h2>Download via FastDL</h2></div>
				<div class="form-title">FastDL code</div>
					<input class="form-field" type="text" name="fastdl" /><br />
				<div class="submit-container">
				<input class="submit-button" type="submit" value="Submit" />
				</div>
				<small>FastDL codes contain id,pass and filename. E.g. <i>aaa|bbb|something.jpg</i>. Due to its containing pass they are insecure but easy to share</small>
				</form>
		<br>
		
		<form class="form-container-info form-container-main <?php if($mobileView) echo 'form-container-main-mobile'; ?>">
				<div class="form-title"><h3></h3></div>
				<div style="text-align:center;">
					<small>Did you know, this project is open source? <a target="_blank" href="http://github.com/rafii6312/sha1base/">GitHub</a> Its still pretty beta but main functions do work.
					This website was first ment to demonstrate my API's functions. Also take a look at my <a target="_blank" href="https://github.com/rafii6312/sha1base/wiki/_pages">Wiki</a>, but its still poorly documentated...
					This project is still in progress, if you find ANY bugs, please contact me on <a target="_blank" href="http://github.com/rafii6312/sha1base/">GitHub</a> so I can fix them as soon as possible.
					Wanna report a file? You can do it <a target="_blank" href="reports.php">here</a>
					</small>
				</div>
			</form>
			<br>
			<form class="form-container-login form-container-main <?php if($mobileView) echo 'form-container-main-mobile'; ?>">
				<div class="form-title">Login (comming soon)</div>
			</form>
			
	</div>
	<div id="nojs">
		<center><p>You have to enable JavaScript to use this site!</p></center>
	</div>
<?php


/*
$data = explode("\n", file_get_contents("/proc/meminfo"));
$meminfo = array();
foreach ($data as $line) {
 	@list($key, $val) = explode(":", $line);
 	$meminfo[$key] = trim($val);
}
//echo 'MEM left/total: ' . round(str_replace(' kB' ,'',$meminfo['MemFree']) / 1024) . '/' . round(str_replace(' kB' ,'',$meminfo['MemTotal']) / 1024) . ' MB<br><br>';


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










