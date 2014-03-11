<?php
error_reporting(E_ALL);
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
$m->cEF('sha1base_sqlite', 'query', "INSERT INTO stats_vs (ip, date) VALUES ('$ip', '$t')");



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
			
			function showSN()
			{
				document.getElementById('impressum').style.display = "block";
				document.getElementById('agb').style.display = "none";
			}
			
			function showAGB()
			{
				document.getElementById('impressum').style.display = "none";
				document.getElementById('agb').style.display = "block";
			}
			
			function showReport()
			{
				document.getElementById('report').style.display = "block";
				document.getElementById('main').style.display = "none";
			}
			
			function hideReport()
			{
				document.getElementById('report').style.display = "none";
				document.getElementById('main').style.display = "block";
				document.getElementById('reportMain').style.display = "block";
				document.getElementById('reportHint').style.display = "none";
				
				document.getElementById('reportId').value = "";
				document.getElementById('reportPass').value = "";
				document.getElementById('reportFastdl').value = "";
				document.getElementById('reportReason').value = "";
				document.getElementById('reportComment').value = "";
			}
		
			
			function hideSNAGB()
			{
				document.getElementById('impressum').style.display = "none";
				document.getElementById('agb').style.display = "none";
			}
			
			function showLogin()
			{
				document.getElementById('login-container').style.display = "block";
				document.getElementById('register-container').style.display = "none";
				document.getElementById('restore-container').style.display = "none";
			}
			
			function showRegister()
			{
				document.getElementById('login-container').style.display = "none";
				document.getElementById('register-container').style.display = "block";
				document.getElementById('restore-container').style.display = "none";
			}
			
			function showRestore()
			{
				document.getElementById('login-container').style.display = "none";
				document.getElementById('register-container').style.display = "none";
				document.getElementById('restore-container').style.display = "block";
			}
			
			function hideLogin()
			{
				document.getElementById('login-container').style.display = "none";
				document.getElementById('register-container').style.display = "none";
				document.getElementById('restore-container').style.display = "none";
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
			 
			 function doReport()
			 {
				var formdata = new FormData();
				formdata.append("id", document.getElementById('reportId').value); 
				formdata.append("pass", document.getElementById('reportPass').value); 
				formdata.append("fastdl", document.getElementById('reportFastdl').value); 
				formdata.append("reason", document.getElementById('reportReason').value); 
				formdata.append("comment", document.getElementById('reportComment').value); 
				
				var ajax = new XMLHttpRequest(); 
				ajax.open("POST", "report.php");
				ajax.send(formdata);
				
				document.getElementById('reportMain').style.display = "none";
				document.getElementById('reportHint').style.display = "block";
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
				hideSNAGB();
			}
			
		</script>
		<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
		<script type="text/javascript" src="js/jquery.form.min.js"></script>
		<meta name="google-site-verification" content="SEbaql24pNuHHgq4cMIRh5I5qSRQDuQ53aPjagQYw9o" />
	</head>
	<body onload="viewPage()">
		<div id="everything" style="display:none;">
			<form id="report" class="form-container-control form-container-main <?php if($mobileView) echo 'form-container-main-mobile'; ?>" style="display:none;">
				<div class="form-title"><h3>Report</h3></div>
				<div id="reportMain">
					<div style="text-align:center;">
						<div class="form-title">File ID</div>
						<input class="form-field" type="text" id="reportId"/><br />
						<div class="form-title">Pass</div>
						<input class="form-field" type="text" id="reportPass" /><br />
						<div class="form-title">FastDl</div>
						<input class="form-field" type="text" id="reportFastdl"/><br />
						<div class="form-title">Reason</div>
						<input class="form-field" type="text" id="reportReason" /><br />
						<div class="form-title">Comment</div>
						<input class="form-field" type="text" id="reportComment" /><br />
						<div class="submit-container">
							<input class="submit-button" onclick="doReport()" type="button" value="Submit Report" />
						</div>
					</div>
				</div>
				<div id="reportHint" style="display:none;">
					<div class="form-title">We received your report.</div>
				</div>
				<div class="form-title"><h3><a href="#" onclick="hideReport()">...return</a></h3></div>
			</form>
			<div id="main">
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
				<small>FastDL codes contain id,pass and filename. E.g. <i>aaa|bbb|something.jpg</i> (base64). Due to its containing pass they are insecure but easy to share</small>
			</form>
			<br>
			<form class="form-container-info form-container-main <?php if($mobileView) echo 'form-container-main-mobile'; ?>">
				<div class="form-title"><h3></h3></div>
				<div style="text-align:center;">
					<small>Did you know, this project is open source? <a target="_blank" href="http://github.com/rafii6312/sha1base/">GitHub</a>. This website was first ment to demonstrate my API's functions. 
					Also take a look at my <a target="_blank" href="https://github.com/rafii6312/sha1base/wiki/_pages">Wiki</a>, but its still poorly documentated...
					This project is still in progress, if you find ANY bugs, please contact me on <a target="_blank" href="http://github.com/rafii6312/sha1base/">GitHub</a> so I can fix them as soon as possible.
					Wanna report a file? You can do it <a href="#" onclick="showReport()">here</a>
					</small>
				</div>
			</form>
			<br>
			<form class="form-container-login form-container-main <?php if($mobileView) echo 'form-container-main-mobile'; ?>">
				<div id="login-control-container">
					<center><h2><a href="#" onclick="showLogin()">Login</a> - <a href="#" onclick="showRegister()">Register</a> - <a href="#" onclick="showRestore()">Restore</a> - <a href="#" onclick="hideLogin()">[hide]</a></h2></center>
				</div>
				<div id="login-container" style="display:none;">
					<div class="form-title"><h2>Login</h2></div>
					<div class="form-title">Username</div>
					<input class="form-field" type="text" id="user" name="id" /><br />
					<div class="form-title">Pass</div>
					<input class="form-field" type="password" id="pass" name="pass" /><br />
					<div class="submit-container">
						<input class="submit-button" type="submit" value="Login" />
					</div>
					<small></small>
				</div>
				<div id="register-container" style="display:none;">
					<div class="form-title"><h2>Register</h2></div>
					<div class="form-title">Username</div>
					<input class="form-field" type="text" id="user" name="id" /><br />
					<div class="form-title">Email</div>
					<input class="form-field" type="text" id="email" name="email" /><br />
					<div class="submit-container">
						<input class="submit-button" type="submit" value="Register" />
					</div>
					<small></small>
				</div>
				<div id="restore-container" style="display:none;">
					<div class="form-title"><h2>Restore</h2></div>
					<div class="form-title">Username</div>
					<input class="form-field" type="text" id="user" name="id" /><br />
					<div class="submit-container">
						<input class="submit-button" type="submit" value="Restore Password" />
					</div>
					<small></small>
				</div>
			</form>
			<br>
			<form class="form-container-impressum form-container-main <?php if($mobileView) echo 'form-container-main-mobile'; ?>">
				<center><a onclick="showSN()" href="#">Site-Notice</a>, <a onclick="showAGB()" href="#">Terms Of Usage</a>, <a onclick="hideSNAGB()" href="#">[hide]</a></center>
				<div style="text-align:center;" id="impressum" style="display:none;">
					<br>
					<h2>Legal Disclosure</h2>
					Information in accordance with section 5 TMG<br/><br/>
					Rafig, Ossami<br/>Brauerstr. 48<br/>76135 Karlsruhe<br/>
					<h3>Contact</h3>Telephone: 02644 6036119<br/>E-Mail: <a href="mailto:webmaster@md5base.de">webmaster@md5base.de</a><br/>
					Internetadress: <a href="http://www.md5base.de" target="_blank">md5base.de</a><br/><h2>Disclaimer</h2>
					Accountability for content<br/>The contents of our pages have been created with the utmost care. 
					However, we cannot guarantee the contents' accuracy, completeness or topicality. According to statutory 
					provisions, we are furthermore responsible for our own content on these web pages. In this context, please 
					note that we are accordingly not obliged to monitor merely the transmitted or saved information of third 
					parties, or investigate circumstances pointing to illegal activity. Our obligations to remove or block the
					use of information under generally applicable laws remain unaffected by this as per &sect;&sect; 8 to 10 
					of the Telemedia Act (TMG).<br/><br/>Accountability for links<br/>Responsibility for the content of 
					external links (to web pages of third parties) lies solely with the operators of the linked pages. 
					No violations were evident to us at the time of linking. Should any legal infringement become known 
					to us, we will remove the respective link immediately.<br/><br/>Copyright<br/> Our web pages and their 
					contents are subject to German copyright law. Unless expressly permitted by law (&sect; 44a et seq. of 
					the copyright law), every form of utilizing, reproducing or processing works subject to copyright protection 
					on our web pages requires the prior consent of the respective owner of the rights. Individual reproductions 
					of a work are allowed only for private use, so must not serve either directly or indirectly for earnings. 
					Unauthorized utilization of copyrighted works is punishable (&sect; 106 of the copyright law).<br/><br/>
				</div>
				<div style="text-align:center;" id="agb" style="display:none;">
					<br>
					While using MD5BASE, you agree not uploading any files, illegal where you live OR illegal in germany (Server location).
					More detailed TOU will follow.
				</div>
			</form>	
		</div>
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










