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
<title></title>

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

<script language="JavaScript">
	function OptionSetDokumen(id){
		$("iframe#idMainFrameDetil")[0].contentWindow.OptionSetDokumen(id);
	}
</script>

</head>

<body leftmargin="0" rightmargin="0" topmargin="0" bottommargin="0">

<div id="kontainer" style="height:100%; min-height:100%;">
	
    <div id="popup-kiri" style="width: 15%">
        <div id="konten-kiri-area">
        	<iframe src="penyusutan_add_menu.php?reqId=<?=$reqId?>" name="menuFramePop" height="100%" scrolling="auto" frameborder="0"></iframe>
        </div>
    </div>
    <div id="popup-kanan" style="width: 85%">
    	<button class="sidebar"></button>
        
        <table cellpadding="0" cellspacing="0" style="width:100%; height:100%;">
            <tr height="50%">
                <td><iframe src="penyusutan_add_data.php?reqId=<?=$reqId?>" class="mainframe" id="idMainFrame" name="mainFramePop" width="100%" height="100%" scrolling="auto" frameborder="0" style="display:block;"></iframe></td>
            </tr>
            <tr height="50%" id="trdetil" style="display:none">
                <td><iframe src="" class="mainframe" id="idMainFrameDetil" name="mainFrameDetilPop" width="100%" height="100%" scrolling="no" frameborder="0" style="display:block;"></iframe></td>
            </tr>
        </table>
        
    </div>
    
</div>


</body>
</html>
