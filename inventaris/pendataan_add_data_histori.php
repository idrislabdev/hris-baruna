<?
include_once("../WEB-INF/page_config.php");
include_once("../WEB-INF/functions/default.func.php");

$pg = httpFilterRequest("pg");
$menu = httpFilterRequest("menu");
$frame = httpFilterRequest("frame");


$reqRowId = httpFilterGet("reqRowId");
$reqId = httpFilterGet("reqId");
$reqInventarisNama = httpFilterGet("reqInventarisNama");
$reqInventarisId = httpFilterGet("reqInventarisId");
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>PT Pelabuhan Indonesia (III) Kotabaru</title>

<link rel="stylesheet" type="text/css" href="../WEB-INF/css/gaya.css">

<script type="text/javascript" src="../WEB-INF/lib/window/js/jquery/jquery.js"></script>

<!-- HIDDEN SIDEBAR -->
<script type='text/javascript'>
	//<![CDATA[ 
	$(window).load(function(){
	$('button').click(function () {
		$('#popup-kiri').toggleClass('hidden');
		$('#popup-kanan').toggleClass('hidden');
	});
	});//]]>  

</script>

<!-- POPUP WINDOW -->
<link rel="stylesheet" href="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.css" type="text/css" />
<script type="text/javascript" src="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.js"></script>
<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>

<script language="JavaScript">
function openPopup(opUrl,opWidth,opHeight)
{
	newWindow = window.open(opUrl, "", "width = " + opWidth + "px, height = " + opHeight + "px, resizable = 1, scrollbars, top = 100, left = 150");
	newWindow.focus();
}

function OpenDHTML(opAddress, opCaption, opWidth, opHeight)
{
	/*var left = (screen.width/2)-(opWidth/2);
    var top = (screen.height/2)-(opHeight/2) - 100;*/
	var left=450;
	
	divwin=dhtmlwindow.open('divbox', 'iframe', opAddress, opCaption, 'width='+opWidth+'px,height='+opHeight+'px,left='+left+',top=20,resize=1,scrolling=1,midle=1'); return false;
}

function reloadParent()
{
	//var left = (screen.width/2)-(opWidth/2);
	window.parent.frames['mainFrameDetilPop'].location.href = 'pendataan_add_data.php?reqId=<?=$reqId?>&reqInventarisId=<?=$reqInventarisId?>&reqInventarisNama=<?=$reqInventarisNama?>';
}
</script>
</head>

<body leftmargin="0" rightmargin="0" topmargin="0" bottommargin="0">
<table cellpadding="0" cellspacing="0" style="width:100%; height:100%;">
    <tr> 
    	<td valign="top" height="100%" width="100%">
            <table cellpadding="0" cellspacing="0"  width="100%" height="100%">
                <tr height="50%">
                    <td><iframe src="pendataan_add_data_histori_monitoring.php?reqLokasiId=<?=$reqId?>&reqId=<?=$reqRowId?>&reqInventarisNama=<?=$reqInventarisNama?>" class="mainframe" id="idMainFrame" name="mainFramePop" width="100%" height="100%" scrolling="auto" frameborder="0" style="display:block;"></iframe></td>
                </tr>
                <tr height="50%" id="trdetil">
                    <td><iframe src="pendataan_add_data_histori_detil.php?reqLokasiId=<?=$reqId?>&reqId=<?=$reqRowId?>" class="mainframe" id="idMainFrameDetil" name="mainFrameDetilPop" width="100%" height="100%" scrolling="no" frameborder="0" style="display:block;"></iframe></td>
                </tr>
            </table>			
		</td>
	</tr>
</table>
</body>
</html>
