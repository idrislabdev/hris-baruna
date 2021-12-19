<?
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$reqId = httpFilterRequest("reqId");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html><head>
<title>Destroydrop &raquo; Javascripts &raquo; Tree</title>
<link rel="stylesheet" type="text/css" href="../WEB-INF/css/admin.css">
<link href="../WEB-INF/css/button_satker.css" rel="stylesheet" type="text/css" />
<style type="text/css">
/* Remove margins from the 'html' and 'body' tags, and ensure the page takes up full screen height */
html, body {height:100%; margin:0; padding:0;}
/* Set the position and dimensions of the background image. */
#page-background {position:fixed; top:0; left:0; width:100%; height:100%;}
/* Specify the position and layering for the content that needs to appear in front of the background image. Must have a higher z-index value than the background image. Also add some padding to compensate for removing the margin from the 'html' and 'body' tags. */
#content {position:relative; z-index:1;}
/* prepares the background image to full capacity of the viewing area */
#bg {position:fixed; top:0; left:0; width:100%; height:100%;}
/* places the content ontop of the background image */
#content {position:relative; z-index:1;}
</style>

<script type="text/javascript" src="../WEB-INF/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.menu-bg, .data,.upload,.scan').append('<span class="hover"></span>').each(function () {
	  		var $span = $('> span.hover', this).css('opacity', 0);
	  		$(this).hover(function () {
	    		$span.stop().fadeTo(500, 1);
	 		}, function () {
	   	$span.stop().fadeTo(500, 0);
	  		});
		});
	});
</script>
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

</head>
<script type="text/javascript">
 
$(document).ready(function(){
 
	$('#page_effect').fadeIn(2000);
 
});
 
</script>

<body leftmargin="5" rightmargin="0" bottommargin="0" topmargin="0" style="overflow-x:hidden;" >
<div id="page_effect" style="display:none;">
<div id="content">

            
            <div id="menu-kiri">

            	<div id="menu-kiri-title"></div>
                <a href="#" id="penyusutan_add_data" class="menu-bg" onclick="executeOnClick('penyusutan_add_data');" style="background-position:0 -27px">
                <div class="menu-kiri-text">
                	Data Pemusnahan
                </div>
                </a>          
                <a href="#" id="penyusutan_add_data_detil" class="menu-bg" onclick="executeOnClick('penyusutan_add_data_detil');">
                <div class="menu-kiri-text">
                	Rincian Inventaris
                </div>
                </a>
            </div>
</div>
</body>

</html>