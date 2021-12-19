<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title>Destroydrop &raquo; Javascripts &raquo; Tree</title>

<link href="css/main.css" rel="stylesheet" type="text/css">
<link href="../WEB-INF/css/button_satker.css" rel="stylesheet" type="text/css" />

<link rel="StyleSheet" href="../WEB-INF/lib/dtree/dtree.css" type="text/css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/dtree/dtree.js"></script>

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

<script type="text/javascript" trdetilsrc="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.hariankapal, .produksipenundaan, .opmesin, .bbm, .airtawar, .presensi').append('<span class="hover"></span>').each(function () {
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

if(varItem == 'hariankapal'){
	$('.hariankapal').css({'background-position': 'bottom'});
	parent.mainFramePop.location.href='atas.php';
	parent.mainFrameDetilPop.location.href='harian_kapal_bawah.php';
	parent.document.getElementById('trdetil').style.display = '';	
}
else if(varItem == 'produksipenundaan'){
	$('.produksipenundaan').css({'background-position': 'bottom'});
	parent.mainFramePop.location.href='atas.php';
	parent.mainFrameDetilPop.location.href='bawah.php';
	parent.document.getElementById('trdetil').style.display = '';	
}
else if(varItem == 'opmesin'){
	$('.opmesin').css({'background-position': 'bottom'});
	parent.mainFramePop.location.href='atas.php';
	parent.mainFrameDetilPop.location.href='bawah.php';
	parent.document.getElementById('trdetil').style.display = '';	
}
else if(varItem == 'bbm'){
	$('.bbm').css({'background-position': 'bottom'});
	parent.mainFramePop.location.href='atas.php';
	parent.mainFrameDetilPop.location.href='bawah.php';
	parent.document.getElementById('trdetil').style.display = '';	
}
else if(varItem == 'airtawar'){
	$('.airtawar').css({'background-position': 'bottom'});
	parent.mainFramePop.location.href='atas.php';
	parent.mainFrameDetilPop.location.href='bawah.php';
	parent.document.getElementById('trdetil').style.display = '';	
}
else if(varItem == 'presensi'){
	$('.presensi').css({'background-position': 'bottom'});
	parent.mainFramePop.location.href='atas.php';
	parent.mainFrameDetilPop.location.href='bawah.php';
	parent.document.getElementById('trdetil').style.display = '';	
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
<!--	<tr>
		<td>
        &nbsp;
		</td>
	</tr>-->
	<tr>
		<td>
			<a href="#" class="hariankapal" onclick="executeOnClick('hariankapal');"></a>
			<a href="#" class="produksipenundaan" onclick="executeOnClick('produksipenundaan');"></a>
			<a href="#" class="opmesin" onclick="executeOnClick('opmesin');"></a>
			<a href="#" class="bbm" onclick="executeOnClick('bbm');"></a>
			<a href="#" class="airtawar" onclick="executeOnClick('airtawar');"></a>
			<a href="#" class="presensi" onclick="executeOnClick('presensi');"></a>
		</td>
	</tr>
</table>
</div>
</div>
</body>

</html>