<?
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

$reqId = httpFilterGet("reqId");
$reqRowId = httpFilterGet("reqRowId");

if($reqId == "")
{
	echo '<script language="javascript">';
	echo "window.parent.divwin.close();";
	echo '</script>';
	exit();
}

$url = $_SERVER['SERVER_ADDR'].$_SERVER['REQUEST_URI'];
$url = explode("simpeg/",$url);
$url = $url[0].'simpeg';
//echo $url;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Administrasi Lampiran</title>


<link rel="stylesheet" href="general.css" type="text/css" media="screen" /> 
<script src="popup.js" type="text/javascript"></script>
 
<link href="themes/main.css" rel="stylesheet" type="text/css" /> 
<script type="text/javascript" src="../WEB-INF/lib/treeTable/doc/javascripts/jquery.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/treeTable/doc/javascripts/jquery.ui.js"></script>

<link href="validate/tabs.css" rel="stylesheet" type="text/css" />
 <style type="text/css" media="screen">
      label {
        font-size: 10px;
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 3px;
        clear: both;
      }
    </style>
<!-- BEGIN Plugin Code -->
  <!-- END Plugin Code -->
  
  <!-- Popup -->  
<link href="styles.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="jquery-1.4.2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.OK,.batal,.close,.donatebutton').append('<span class="hover"></span>').each(function () {
			var $span = $('> span.hover', this).css('opacity', 0);
			$(this).hover(function () {
				$span.stop().fadeTo(500, 1);
			}, function () {
		$span.stop().fadeTo(500, 0);
			});
		});
	});	
</script>

<script src="js/forms/jquery.uniform.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
  $(function(){
	$("input, textarea, select, button").uniform();
  });
</script>
<link rel="stylesheet" href="js/forms/css/uniform.default.css" type="text/css" media="screen">

<script language="Javascript">
<? include_once "../jslib/formHandler.php"; ?>

function openPopup(opUrl,opWidth,opHeight)
{
	newWindow = window.open(opUrl, "", "width = " + opWidth + "px, height = " + opHeight + "px, resizable = 1, scrollbars");
	newWindow.focus();
}
function CloseAndRefresh() 
{
    window.opener.location.href = window.opener.location.href;
    window.close();
}
</script>
<script language="JavaScript" src="../jslib/displayElement.js"></script>  
</head>
<script type="text/javascript">
 
$(document).ready(function(){
 
	$('#page_effect').fadeIn(2000);
 
});
 
</script>
<body>

<script language=JavaScript>
<!--

//Disable right mouse click Script
//By Maximus (maximus@nsimail.com) w/ mods by DynamicDrive
//For full source code, visit http://www.dynamicdrive.com

var message="Function Disabled!";

///////////////////////////////////
function clickIE4(){
if (event.button==2){
alert(message);
return false;
}
}

function clickNS4(e){
if (document.layers||document.getElementById&&!document.all){
if (e.which==2||e.which==3){
alert(message);
return false;
}
}
}

if (document.layers){
document.captureEvents(Event.MOUSEDOWN);
document.onmousedown=clickNS4;
}
else if (document.all&&!document.getElementById){
document.onmousedown=clickIE4;
}

document.oncontextmenu=new Function("return false")

// --> 
</script>

<div id="content" style="height:auto; margin-top:-4px; width:100%">
<div class="content" style="height:100%; width:100%;overflow:hidden; overflow:-x:hidden; overflow-y:auto; position:fixed;">
  <applet code="uk.co.mmscomputing.application.imageviewer.MainApp.class" archive="imageviewer/imageviewer.jar" width="100%" height="100%">
      <param name="upload_url" value="http://<?=$url?>/pegawai_add_sertifikat_add_data_scan_upload.php?reqId=<?=$reqId?>&reqRowId=<?=$reqRowId?>" />
      <param name="surat_id" value="4" />
      <param name="no_urut" value="" />
      <param name="enableButton" value="true" />
  </applet>
</div>
</div>
	</body>
</html>
