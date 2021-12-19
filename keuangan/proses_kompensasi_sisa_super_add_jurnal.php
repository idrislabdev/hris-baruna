<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");

$reqId = httpFilterGet("reqId");

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<link rel="icon" 
      type="image/ico" 
      href="images/favicon.ico" />
<title>Reporting Application</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="StyleSheet" href="../WEB-INF/lib/dtree/dtree.css" type="text/css" />
<link href="css/tabs.css" rel="stylesheet" type="text/css" />
<link href="css/main.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="../jslib/displayElement.js"></script>

<!-- POPUP WINDOW -->
<link rel="stylesheet" href="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.css" type="text/css" />
<script type="text/javascript" src="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.js"></script>
<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>

<link href="../WEB-INF/images/tabs.css" rel="stylesheet" type="text/css" />

<script language="JavaScript">
function openPopup(opUrl,opWidth,opHeight)
{
	newWindow = window.open(opUrl, "", "width = " + opWidth + "px, height = " + opHeight + "px, resizable = 1, scrollbars, top = 100, left = 150");
	newWindow.focus();
}
</script>
<link rel="stylesheet" href="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.css" type="text/css" />
<script type="text/javascript" src="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.js"></script>
<script>
  function OpenDHTML(opAddress, opCaption, opWidth, opHeight)
  {
	  var left = (screen.width/2)-(opWidth/2);
	  //var left=50;
	  
	  divwin=dhtmlwindow.open('divbox', 'iframe', opAddress, opCaption, 'width='+opWidth+'px,height='+opHeight+'px,left='+left+',top=40,resize=1,scrolling=1,midle=1'); return false;
  }

	function OptionSet(id, nama,alamat, npwp, badan_usaha){
		window.frames["mainFramePop"].OptionSet(id, nama,alamat, npwp, badan_usaha);
	}	
	  
</script>

<style>
body{ overflow:hidden; margin:0 0;}
#linearBg{ 
	/* fallback */ 
	background-color: #FFF; 
	background-image: url(images/linear_bg_1.png); 
	background-repeat: repeat-y; 
	
	/* Safari 4-5, Chrome 1-9 */ 
	background: -webkit-gradient(linear, left top, right top, from(#FFF), to(#d9e7fe)); 
	
	/* Safari 5.1, Chrome 10+ */ 
	background: -webkit-linear-gradient(left, #FFF, #d9e7fe); 
	
	/* Firefox 3.6+ */ 
	background: -moz-linear-gradient(left, #FFF, #d9e7fe); 
	
	/* IE 10 */ 
	background: -ms-linear-gradient(left, #FFF, #d9e7fe); 
	
	/* Opera 11.10+ */ 
	background: -o-linear-gradient(left, #FFF, #d9e7fe); 
}
</style>
</head>

<body id="linearBg">
<ol id="toc" style="margin-bottom:-1px; margin-top:-3px;">
    <li><a href="proses_kompensasi_sisa_super_add.php?reqId=<?=$reqId?>"><span>Pelunasan</span></a></li>
    <li class="current"><a href="#"><span>Jurnal</span></a></li>
</ol>

<div style="height:100%;">
	<!-- frame atas -->
    <div style="height:50%;">
	    <iframe src="proses_kompensasi_sisa_super_add_jurnal_data.php?reqId=<?=$reqId?>" class="mainframe" id="idMainFrame" name="mainFramePop" width="100%" height="100%" scrolling="no" frameborder="0"></iframe>
    </div>
    
    <!-- frame bawah -->
    <div style="height:50%;">
    	<iframe src="proses_kompensasi_sisa_super_add_jurnal_data_detil.php?reqId=<?=$reqId?>" class="mainframe" id="idMainFrameDetil" name="mainFrameDetilPop" width="100%" height="100%" scrolling="no" frameborder="0"></iframe>
    </div>
    
</div>
</body>
</html>
