<?
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");

$reqId = httpFilterRequest("reqId");

if($reqId == ""){}
else
{
	$pegawai = new Pegawai();
	$pegawai->selectByParams(array("A.PEGAWAI_ID" => $reqId));
	$pegawai->firstRow();
	
	$tempNRP = $pegawai->getField('NRP');
	$tempNama = $pegawai->getField('NAMA');
	$tempKelas = $pegawai->getField('KELAS');
	$tempJabatanNama = $pegawai->getField('JABATAN_NAMA');
}
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
$('a').css({'background-position': 'top'});

if(varItem == 'pegawai_add_data'){
	$('#pegawai_add_data').css({'background-position': '0 -27px'});
	parent.mainFramePop.location.href='pegawai_add_data.php?reqId=<?=$reqId?>';
	parent.document.getElementById('trdetil').style.display = 'none';	
}
else if(varItem == 'pegawai_add_sk_pegawai'){
	$('#pegawai_add_sk_pegawai').css({'background-position': '0 -27px'});
	parent.mainFramePop.location.href='pegawai_add_sk_pegawai.php?reqId=<?=$reqId?>';
	parent.document.getElementById('trdetil').style.display = 'none';	
}
return true;
}

function check_jenis_pegawai_terakhir(id){
	alert('Check menu: '+id);
}

function hide_perubahan_pangkat(id){
	//alert('pegawai menu: '+id);
	
	$.getJSON('../json-simpeg/pegawai_add_jenis_pegawai_cek.php?reqId='+id,
		function(data){
			//alert(data.reqId+'--'+data.jenis_pegawai_id)
			if(data.jenis_pegawai_id == '2'){
				$("#pegawai_add_jabatan_perbantuan").show();
				$("#pegawai_add_pangkat").show();
			}else{
				$("#pegawai_add_jabatan_perbantuan").hide();
				$("#pegawai_add_pangkat").hide();
			}
		});
}
</script> 

</head>
<script type="text/javascript">
 
$(document).ready(function(){
 
	$('#page_effect').fadeIn(2000);
 
});
 
</script>

<body leftmargin="5" rightmargin="0" bottommargin="0" topmargin="0" onload="hide_perubahan_pangkat('<?=$reqId?>')">
<div id="page_effect" style="display:none;">
<div id="bg"><img src="../WEB-INF/images/bg-kiri-popup.jpg" width="100%" height="100%" alt=""></div>
<div id="content">
<table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
	<tr>
		<td>
        	<? if($reqId == ''){}else{?>
        	<div style="background-image:url(../WEB-INF/images/bg-identitas.png)">
            	<div id="menu-kiri-title-identitas">IDENTITAS</div>
                <div style="margin-top:5px; width:230px; margin-left:5px; float:left; position:relative; text-align:left;">
                    <div style="border:2px solid #FFF; float:left; margin-right:4px; height:66px; width:50px; -webkit-box-shadow: 0 8px 6px -6px black; -moz-box-shadow: 0 8px 6px -6px black; box-shadow: 0 8px 6px -6px black;">
                    	<img src="image_script.php?reqPegawaiId=<?=$reqId?>&reqMode=pegawai" width="50" height="66">
                    	<!--<img src="images/pns.jpg" width="50" height="66" />-->
                    </div>
    
                    <div style="float:left; position:relative; width:170px; border-bottom:1px dashed #FFF;"> 
                        <div style="color:#FFF; font-size:18px; text-shadow:1px 1px 1px #000;"><?=$tempNama?></div>     
                        <div style="color:#FFF; font-size:12px; text-shadow:1px 1px 1px #000; line-height:20px;">NRP : <?=$tempNRP?></div>
                        <div>&nbsp;</div>
                    </div>
                    
                </div>
                <div style="color:#FFF; text-align:center; margin-left:5px; font-size:20px; line-height:34px; text-shadow:1px 1px 1px #000;">
                <!--<img src="../WEB-INF/images/chair.png" />&nbsp;-->
                -&nbsp;<?=$tempJabatanNama?> / <?=$tempKelas?>&nbsp;-
                </div>
			</div>            
            <? }?>
            
            <div id="menu-kiri">

            	<div id="menu-kiri-title">FIP 01</div>
                <a href="#" id="pegawai_add_data" class="menu-bg" onclick="executeOnClick('pegawai_add_data');" style="background-position:0 -27px">
                <div class="menu-kiri-text">
                	<img src="../WEB-INF/images/administrator.png" height="24" class="top" />Data Pegawai
                </div>
                </a>

                <a href="#" id="pegawai_add_sk_calon_pegawai" class="menu-bg" onclick="executeOnClick('pegawai_add_sk_calon_pegawai');">
                <div class="menu-kiri-text">
                	<img src="../WEB-INF/images/sk-cpns.png" height="24" class="top" />SK Calon Pegawai
                </div>
                </a>

                <a href="#" id="pegawai_add_sk_pegawai" class="menu-bg" onclick="executeOnClick('pegawai_add_sk_pegawai');">
                <div class="menu-kiri-text">
                	<img src="../WEB-INF/images/sk-pns.png" height="24" class="top" />SK Pegawai
                </div>
                </a>
            </div>
		</td>
	</tr>
</table>
</div>
</div>
</body>

</html>