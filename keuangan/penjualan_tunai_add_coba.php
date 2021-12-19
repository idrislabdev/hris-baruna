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
<link href="tabs.css" rel="stylesheet" type="text/css" />
<link href="themes/main.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="../jslib/displayElement.js"></script>
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

</head>

<body leftmargin="0" rightmargin="0" topmargin="0" bottommargin="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" height="100%" bgcolor="#F0F0F0" style="overflow:hidden">
   	<tr> 
    	<td valign="top" height="100%" width="100%">
            <table cellpadding="0" cellspacing="0"  width="100%" height="100%">
            	<tr height="50%">
                	<td><iframe src="penjualan_tunai_add_data.php?reqId=<?=$reqId?>" class="mainframe" id="idMainFrame" name="mainFramePop" width="100%" height="100%" scrolling="auto" frameborder="0"></iframe></td>
                </tr>
            	<?php ?><tr height="50%" id="trdetil">
                	<td><iframe src="penjualan_tunai_add_data_detil.php?reqId=<?=$reqId?>" class="mainframe" id="idMainFrameDetil" name="mainFrameDetilPop" width="100%" height="100%" scrolling="no" frameborder="0"></iframe></td>
                </tr><?php ?>
            </table>			
		</td>
	</tr>
</table>
</body>
</html>
