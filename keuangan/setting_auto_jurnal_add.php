<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/TransaksiTipe.php");

$transaksi_tipe = new TransaksiTipe();

$reqId = httpFilterGet("reqId");
$reqRowId = httpFilterGet("reqRowId");

$transaksi_tipe->selectByParams(array("A.MODUL_ID"=>$reqId, "A.JURNAL_ID"=>$reqRowId), -1, -1);
$transaksi_tipe->firstRow();
$tempRowId= $transaksi_tipe->getField("TRANSAKSI_TIPE_ID");
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
</head>

<body leftmargin="0" rightmargin="0" topmargin="0" bottommargin="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" height="100%" bgcolor="#F0F0F0" style="overflow:hidden">
   	<tr> 
    	<td valign="top" height="100%" width="100%">
            <table cellpadding="0" cellspacing="0"  width="100%" height="100%">
            	<tr height="50%">
                	<td><iframe src="setting_auto_jurnal_add_transaksi_tipe_monitoring.php?reqId=<?=$reqId?>&reqRowId=<?=$reqRowId?>" class="mainframe" id="idMainFrame" name="mainFramePop" width="100%" height="100%" scrolling="auto" frameborder="0"></iframe></td>
                </tr>
            	<tr height="50%">
                	<td><iframe src="setting_auto_jurnal_add_transaksi_tipe.php?reqRowId=<?=$tempRowId?>" class="mainframe" id="idMainFrameDetil" name="mainFrameDetilPop" width="100%" height="100%" scrolling="auto" frameborder="0"></iframe></td>
                </tr>
            </table>			
		</td>
	</tr>
</table>
</body>
</html>
