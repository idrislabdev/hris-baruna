<?
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$reqId = httpFilterRequest("reqId");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title>Destroydrop &raquo; Javascripts &raquo; Tree</title>
<script type="text/javascript" src="../WEB-INF/js/jquery-1.3.2.min.js"></script>

<script type="text/javascript">
function executeOnClick(varItem){

if(varItem == 'penyusutan_add_data'){
	$('#penyusutan_add_data').css({'background-position': '0 -27px'});
	parent.mainFramePop.location.href='penyusutan_add_data_add.php?reqId=<?=$reqId?>';
	parent.document.getElementById('trdetil').style.display = 'none';	
}
else if(varItem == 'penyusutan_add_data_detil'){
	$('#penyusutan_add_data_detil').css({'background-position': '0 -27px'});
	parent.mainFramePop.location.href='penyusutan_add_data_detil.php?reqId=<?=$reqId?>';
	parent.document.getElementById('trdetil').style.display = 'none';			
}
return true;
}

</script>

<link rel="stylesheet" type="text/css" href="../WEB-INF/css/gaya.css">

</head>
<script type="text/javascript">
 
$(document).ready(function(){
 
	$('#page_effect').fadeIn(2000);
 
});
 
</script>

<body>
<div id="page_effect" style="display:none;">
	<div id="bg"><img src="../WEB-INF/images/bg-kiri-popup.jpg" width="100%" height="100%" alt=""></div>

	<div id="menu-kiri">
        <div><a href="#" id="penyusutan_add_data" onclick="executeOnClick('penyusutan_add_data');">Data Pemusnahan</a></div>
        <div><a href="#" id="penyusutan_add_data_detil" onclick="executeOnClick('penyusutan_add_data_detil');">Rincian Inventaris</a></div>
    </div>
    </div>
</div>
</body>

</html>