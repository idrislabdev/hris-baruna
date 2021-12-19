<?
include_once("../WEB-INF/page_config.php");
include_once("../WEB-INF/functions/default.func.php");

$pg = httpFilterRequest("pg");
$menu = httpFilterRequest("menu");
$frame = httpFilterRequest("frame");

$reqId = httpFilterGet("reqId");
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
	var left = (screen.width/2)-(opWidth/2);
    var top = (screen.height/2)-(opHeight/2) - 100;
	
	divwin=dhtmlwindow.open('divbox', 'iframe', opAddress, opCaption, 'width='+opWidth+'px,height='+opHeight+'px,left='+left+',top=20,resize=1,scrolling=1,midle=1'); return false;
}

function DwinClose()
{
	divwin.close();
}
</script>

<script language="JavaScript">
	function OptionSetDokumen(id){
		$("iframe#idMainFrameDetil")[0].contentWindow.OptionSetDokumen(id);
	}
</script>

</head>

<body leftmargin="0" rightmargin="0" topmargin="0" bottommargin="0">
<table cellpadding="0" cellspacing="0" style="width:100%; height:100%;">
    <tr height="60%">
        <td><iframe src="pendataan_add_monitoring.php?reqId=<?=$reqId?>" class="mainframe" id="idMainFrame" name="mainFramePop" width="100%" height="100%" scrolling="auto" frameborder="0" style="display:block;"></iframe></td>
    </tr>
    <tr height="40%" id="trdetil">
        <td><iframe src="pendataan_add_data.php?reqId=" class="mainframe" id="idMainFrameDetil" name="mainFrameDetilPop" width="100%" height="100%" scrolling="no" frameborder="0" style="display:block;"></iframe></td>
    </tr>
</table>
</body>
</html>
