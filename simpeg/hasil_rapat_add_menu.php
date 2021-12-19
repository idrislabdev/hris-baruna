<?
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");
$reqId = httpFilterRequest("reqId");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
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
		$('.data,.upload,.scan').append('<span class="hover"></span>').each(function () {
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
$('a').css({'background-position': 'top'});

if(varItem == 'master_pegawai'){
	$('.data').css({'background-position': 'bottom'});
	parent.mainFramePop.location.href='master_pegawai_add.php?reqId=<?=$reqId?>';
	parent.document.getElementById('trdetil').style.display = 'none';	
}
else if(varItem == 'master_sk_pns'){
	$('.data').css({'background-position': 'bottom'});
	parent.mainFramePop.location.href='master_sk_pns_add.php?reqId=<?=$reqId?>';
	parent.document.getElementById('trdetil').style.display = 'none';	
}
else if(varItem == 'master_sk_cpns'){
	$('.data').css({'background-position': 'bottom'});
	parent.mainFramePop.location.href='master_sk_cpns_add.php?reqId=<?=$reqId?>';
	parent.document.getElementById('trdetil').style.display = 'none';	
}
else if(varItem == 'jabatan'){
	$('.upload').css({'background-position': 'bottom'});
	parent.mainFramePop.location.href='jabatan_add_monitoring.php?reqId=<?=$reqId?>';
	parent.mainFrameDetilPop.location.href='jabatan_add.php?reqId=<?=$reqId?>';
	parent.document.getElementById('trdetil').style.display = '';		
}
else if(varItem == 'pangkat'){
	$('.upload').css({'background-position': 'bottom'});
	parent.mainFramePop.location.href='pangkat_add_monitoring.php?reqId=<?=$reqId?>';
	parent.mainFrameDetilPop.location.href='pangkat_add.php?reqId=<?=$reqId?>';
	parent.document.getElementById('trdetil').style.display = '';		
}
else if(varItem == 'penghasilan'){
	$('.upload').css({'background-position': 'bottom'});
	parent.mainFramePop.location.href='penghasilan_add_monitoring.php?reqId=<?=$reqId?>';
	parent.mainFrameDetilPop.location.href='penghasilan_add.php?reqId=<?=$reqId?>';
	parent.document.getElementById('trdetil').style.display = '';		
}
else if(varItem == 'tpp'){
	$('.upload').css({'background-position': 'bottom'});
	parent.mainFramePop.location.href='tpp_add_monitoring.php?reqId=<?=$reqId?>';
	parent.mainFrameDetilPop.location.href='tpp_add.php?reqId=<?=$reqId?>';
	parent.document.getElementById('trdetil').style.display = '';		
}
else if(varItem == 'tunjangan'){
	$('.upload').css({'background-position': 'bottom'});
	parent.mainFramePop.location.href='tunjangan_add_monitoring.php?reqId=<?=$reqId?>';
	parent.mainFrameDetilPop.location.href='tunjangan_add.php?reqId=<?=$reqId?>';
	parent.document.getElementById('trdetil').style.display = '';		
}
else if(varItem == 'jenis_pegawai'){
	$('.upload').css({'background-position': 'bottom'});
	parent.mainFramePop.location.href='jenis_pegawai_add_monitoring.php?reqId=<?=$reqId?>';
	parent.mainFrameDetilPop.location.href='jenis_pegawai_add.php?reqId=<?=$reqId?>';
	parent.document.getElementById('trdetil').style.display = '';		
}
else if(varItem == 'pendidikan'){
	$('.upload').css({'background-position': 'bottom'});
	parent.mainFramePop.location.href='pendidikan_add_monitoring.php?reqId=<?=$reqId?>';
	parent.mainFrameDetilPop.location.href='pendidikan_add.php?reqId=<?=$reqId?>';
	parent.document.getElementById('trdetil').style.display = '';		
}
else if(varItem == 'status'){
	$('.upload').css({'background-position': 'bottom'});
	parent.mainFramePop.location.href='status_add_monitoring.php?reqId=<?=$reqId?>';
	parent.mainFrameDetilPop.location.href='status_add.php?reqId=<?=$reqId?>';
	parent.document.getElementById('trdetil').style.display = '';		
}
else if(varItem == 'keluarga'){
	$('.upload').css({'background-position': 'bottom'});
	parent.mainFramePop.location.href='keluarga_add_monitoring.php?reqId=<?=$reqId?>';
	parent.mainFrameDetilPop.location.href='keluarga_add.php?reqId=<?=$reqId?>';
	parent.document.getElementById('trdetil').style.display = '';		
}
else if(varItem == 'puspel'){
	$('.upload').css({'background-position': 'bottom'});
	parent.mainFramePop.location.href='puspel_add_monitoring.php?reqId=<?=$reqId?>';
	parent.mainFrameDetilPop.location.href='puspel_add.php?reqId=<?=$reqId?>';
	parent.document.getElementById('trdetil').style.display = '';		
}
else if(varItem == 'scan'){
	$('.scan').css({'background-position': 'bottom'});
	parent.mainFramePop.location.href='hasil_rapat_add_scan.php?reqId=<?=$reqId?>';
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
<body leftmargin="5" rightmargin="0" bottommargin="0" topmargin="0" >
<div id="page_effect" style="display:none;">
<div id="bg"><img src="../WEB-INF/images/bg-kiri-popup.jpg" width="100%" height="100%" alt=""></div>
<div id="content">
<table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
	<tr>
		<td>
            <a href="#" class="data" onclick="executeOnClick('master_pegawai');" style="background-position:bottom"></a>
            <a href="#" class="data" onclick="executeOnClick('master_sk_pns');"></a>
            <a href="#" class="data" onclick="executeOnClick('master_sk_cpns');"></a>
            <a href="#" class="upload" onclick="executeOnClick('jabatan');"></a>
            <a href="#" class="upload" onclick="executeOnClick('pangkat');"></a>
            <a href="#" class="upload" onclick="executeOnClick('penghasilan');"></a>
            <a href="#" class="upload" onclick="executeOnClick('tpp');"></a>
            <a href="#" class="upload" onclick="executeOnClick('tunjangan');"></a>
            <a href="#" class="upload" onclick="executeOnClick('jenis_pegawai');"></a>
            <a href="#" class="upload" onclick="executeOnClick('pendidikan');"></a>
            <a href="#" class="upload" onclick="executeOnClick('status');"></a>
            <a href="#" class="upload" onclick="executeOnClick('keluarga');"></a>
            <a href="#" class="upload" onclick="executeOnClick('puspel');"></a>
            <!--<a href="#" class="scan" onclick="executeOnClick('scan');"></a>-->
		</td>
	</tr>
</table>
</div>
</div>
</body>

</html>