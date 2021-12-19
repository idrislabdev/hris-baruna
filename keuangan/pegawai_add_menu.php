<?
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/date.func.php");
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
	$tempZodiac = getZodiac((int)getDay($pegawai->getField("TANGGAL_LAHIR")), (int)getMonth($pegawai->getField("TANGGAL_LAHIR")));
	$tempJabatanNama = $pegawai->getField('JABATAN_NAMA');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title>Destroydrop &raquo; Javascripts &raquo; Tree</title>
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
else if(varItem == 'pegawai_add_sk_calon_pegawai'){
	$('#pegawai_add_sk_calon_pegawai').css({'background-position': '0 -27px'});
	parent.mainFramePop.location.href='pegawai_add_sk_calon_pegawai.php?reqId=<?=$reqId?>';
	parent.document.getElementById('trdetil').style.display = 'none';	
}
else if(varItem == 'pegawai_add_jabatan'){
	$('#pegawai_add_jabatan').css({'background-position': '0 -27px'});
	parent.mainFramePop.location.href='pegawai_add_jabatan_monitoring.php?reqId=<?=$reqId?>';
	parent.mainFrameDetilPop.location.href='pegawai_add_jabatan.php?reqId=<?=$reqId?>';
	parent.document.getElementById('trdetil').style.display = '';		
}
else if(varItem == 'pegawai_add_jabatan_perbantuan'){
	$('#pegawai_add_jabatan_perbantuan').css({'background-position': '0 -27px'});
	parent.mainFramePop.location.href='pegawai_add_jabatan_perbantuan_monitoring.php?reqId=<?=$reqId?>';
	parent.mainFrameDetilPop.location.href='pegawai_add_jabatan_perbantuan.php?reqId=<?=$reqId?>';
	parent.document.getElementById('trdetil').style.display = '';		
}
else if(varItem == 'pegawai_add_pangkat'){
	$('#pegawai_add_pangkat').css({'background-position': '0 -27px'});
	parent.mainFramePop.location.href='pegawai_add_pangkat_monitoring.php?reqId=<?=$reqId?>';
	parent.mainFrameDetilPop.location.href='pegawai_add_pangkat.php?reqId=<?=$reqId?>';
	parent.document.getElementById('trdetil').style.display = '';		
}
else if(varItem == 'pegawai_add_penghasilan'){
	$('#pegawai_add_penghasilan').css({'background-position': '0 -27px'});
	parent.mainFramePop.location.href='pegawai_add_penghasilan_monitoring.php?reqId=<?=$reqId?>';
	parent.mainFrameDetilPop.location.href='pegawai_add_penghasilan.php?reqId=<?=$reqId?>';
	parent.document.getElementById('trdetil').style.display = '';		
}
else if(varItem == 'pegawai_add_tpp'){
	$('#pegawai_add_tpp').css({'background-position': '0 -27px'});
	parent.mainFramePop.location.href='pegawai_add_tpp_monitoring.php?reqId=<?=$reqId?>';
	parent.mainFrameDetilPop.location.href='pegawai_add_tpp.php?reqId=<?=$reqId?>';
	parent.document.getElementById('trdetil').style.display = '';		
}
else if(varItem == 'pegawai_add_tunjangan'){
	$('#pegawai_add_tunjangan').css({'background-position': '0 -27px'});
	parent.mainFramePop.location.href='pegawai_add_tunjangan_monitoring.php?reqId=<?=$reqId?>';
	parent.mainFrameDetilPop.location.href='pegawai_add_tunjangan.php?reqId=<?=$reqId?>';
	parent.document.getElementById('trdetil').style.display = '';		
}
else if(varItem == 'pegawai_add_jenis_pegawai'){
	$('#pegawai_add_jenis_pegawai').css({'background-position': '0 -27px'});
	parent.mainFramePop.location.href='pegawai_add_jenis_pegawai_monitoring.php?reqId=<?=$reqId?>';
	parent.mainFrameDetilPop.location.href='pegawai_add_jenis_pegawai.php?reqId=<?=$reqId?>';
	parent.document.getElementById('trdetil').style.display = '';		
}
else if(varItem == 'pegawai_add_pendidikan'){
	$('#pegawai_add_pendidikan').css({'background-position': '0 -27px'});
	parent.mainFramePop.location.href='pegawai_add_pendidikan_monitoring.php?reqId=<?=$reqId?>';
	parent.mainFrameDetilPop.location.href='pegawai_add_pendidikan.php?reqId=<?=$reqId?>';
	parent.document.getElementById('trdetil').style.display = '';		
}
else if(varItem == 'pegawai_add_pendidikan_perjenjangan'){
	$('#pegawai_add_pendidikan_perjenjangan').css({'background-position': '0 -27px'});
	parent.mainFramePop.location.href='pegawai_add_pendidikan_perjenjangan_monitoring.php?reqId=<?=$reqId?>';
	parent.mainFrameDetilPop.location.href='pegawai_add_pendidikan_perjenjangan.php?reqId=<?=$reqId?>';
	parent.document.getElementById('trdetil').style.display = '';		
}
else if(varItem == 'pegawai_add_pendidikan_substansial'){
	$('#pegawai_add_pendidikan_substansial').css({'background-position': '0 -27px'});
	parent.mainFramePop.location.href='pegawai_add_pendidikan_substansial_monitoring.php?reqId=<?=$reqId?>';
	parent.mainFrameDetilPop.location.href='pegawai_add_pendidikan_substansial.php?reqId=<?=$reqId?>';
	parent.document.getElementById('trdetil').style.display = '';		
}
else if(varItem == 'pegawai_add_status_nikah'){
	$('#pegawai_add_status_nikah').css({'background-position': '0 -27px'});
	parent.mainFramePop.location.href='pegawai_add_status_nikah_monitoring.php?reqId=<?=$reqId?>';
	parent.mainFrameDetilPop.location.href='pegawai_add_status_nikah.php?reqId=<?=$reqId?>';
	parent.document.getElementById('trdetil').style.display = '';		
}
else if(varItem == 'pegawai_add_keluarga'){
	$('#pegawai_add_keluarga').css({'background-position': '0 -27px'});
	parent.mainFramePop.location.href='pegawai_add_keluarga_monitoring.php?reqId=<?=$reqId?>';
	parent.mainFrameDetilPop.location.href='pegawai_add_keluarga.php?reqId=<?=$reqId?>';
	parent.document.getElementById('trdetil').style.display = '';		
}
else if(varItem == 'pegawai_add_puspel'){
	$('#pegawai_add_puspel').css({'background-position': '0 -27px'});
	parent.mainFramePop.location.href='pegawai_add_puspel_monitoring.php?reqId=<?=$reqId?>';
	parent.mainFrameDetilPop.location.href='pegawai_add_puspel.php?reqId=<?=$reqId?>';
	parent.document.getElementById('trdetil').style.display = '';		
}
else if(varItem == 'pegawai_add_sertifikat'){
	$('#pegawai_add_sertifikat').css({'background-position': '0 -27px'});
	parent.mainFramePop.location.href='pegawai_add_sertifikat.php?reqId=<?=$reqId?>';
	parent.document.getElementById('trdetil').style.display = 'none';	
}
else if(varItem == 'pegawai_add_perubahan_alamat'){
	$('#pegawai_add_perubahan_alamat').css({'background-position': '0 -27px'});
	parent.mainFramePop.location.href='pegawai_add_perubahan_alamat_monitoring.php?reqId=<?=$reqId?>';
	parent.mainFrameDetilPop.location.href='pegawai_add_perubahan_alamat.php?reqId=<?=$reqId?>';
	parent.document.getElementById('trdetil').style.display = '';		
}
else if(varItem == 'pegawai_add_hukuman'){
	$('#pegawai_add_hukuman').css({'background-position': '0 -27px'});
	parent.mainFramePop.location.href='pegawai_add_hukuman_monitoring.php?reqId=<?=$reqId?>';
	parent.mainFrameDetilPop.location.href='pegawai_add_hukuman.php?reqId=<?=$reqId?>';
	parent.document.getElementById('trdetil').style.display = '';		
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
			if(data.jenis_pegawai_id == '2' || data.jenis_pegawai_id == '6' || data.jenis_pegawai_id == '7'){
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
<div id="bg"><img src="images/wall-kiri.jpg" width="100%" height="100%" alt=""></div>
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
                        <div style="color:#FFF; font-size:14px; text-shadow:1px 1px 1px #000;"><?=$tempNama?></div>     
                        <div style="color:#FFF; font-size:12px; text-shadow:1px 1px 1px #000; line-height:20px;">NRP : <?=$tempNRP?></div>
                        <div style="color:#FFF; font-size:12px; text-shadow:1px 1px 1px #000; line-height:20px;">Zodiac : <?=$tempZodiac?></div>
                        
                    </div>
                    
                </div>
                <div style="color:#FFF; text-align:center; margin-left:5px; font-size:16px; line-height:34px; text-shadow:1px 1px 1px #000;">
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
                
                <!-- ******************************************************************************************************** -->
				<div id="menu-kiri-title">FIP 02</div>                
                <a href="#" id="pegawai_add_jenis_pegawai" class="menu-bg" onclick="executeOnClick('pegawai_add_jenis_pegawai');">
                <div class="menu-kiri-text">
                	<img src="../WEB-INF/images/jenis-pegawai.png" height="24" class="top" />Jenis Pegawai
                </div>
                </a>
                
                
                <a href="#" id="pegawai_add_jabatan" class="menu-bg" onclick="executeOnClick('pegawai_add_jabatan');">
                <div class="menu-kiri-text">
                	<img src="../WEB-INF/images/jabatan.png" height="24" class="top" />Data Jabatan
                </div>
                </a>
                
                <?php /*?><div id="perbantuan_pangkat"><?php */?>
                <a href="#" id="pegawai_add_jabatan_perbantuan" class="menu-bg" onclick="executeOnClick('pegawai_add_jabatan_perbantuan');">
                <div class="menu-kiri-text">
                	<img src="../WEB-INF/images/jabatan.png" height="24" class="top" />Data Jabatan Perbantuan
                </div>
                </a>
                
                <a href="#" id="pegawai_add_pangkat" class="menu-bg" onclick="executeOnClick('pegawai_add_pangkat');">
                <div class="menu-kiri-text">
                	<img src="../WEB-INF/images/pangkat.png" height="24" class="top" />Data Pangkat
                </div>
                </a>
                <?php /*?></div><?php */?>
                
                <a href="#" id="pegawai_add_penghasilan" class="menu-bg" onclick="executeOnClick('pegawai_add_penghasilan');">
                <div class="menu-kiri-text">
                	<img src="../WEB-INF/images/penghasilan.png" height="24" class="top" />Data Penghasilan
                </div>
                </a>
                <div id="menu-kiri-title">FIP 03</div> 
				<a href="#" id="pegawai_add_pendidikan_perjenjangan" class="menu-bg" onclick="executeOnClick('pegawai_add_pendidikan_perjenjangan');">
                <div class="menu-kiri-text">
                	<img src="../WEB-INF/images/pendidikan.png" height="24" class="top" />Data Pendidikan Perjenjangan
                </div>
                </a>
                
                <a href="#" id="pegawai_add_pendidikan_substansial" class="menu-bg" onclick="executeOnClick('pegawai_add_pendidikan_substansial');">
                <div class="menu-kiri-text">
                	<img src="../WEB-INF/images/pendidikan.png" height="24" class="top" />Data Pendidikan Substansial
                </div>
                </a>
				
                <a href="#" id="pegawai_add_pendidikan" class="menu-bg" onclick="executeOnClick('pegawai_add_pendidikan');">
                <div class="menu-kiri-text">
                	<img src="../WEB-INF/images/pendidikan.png" height="24" class="top" />Data Pendidikan
                </div>
                </a>
                
                <a href="#" id="pegawai_add_status_nikah" class="menu-bg" onclick="executeOnClick('pegawai_add_status_nikah');">
                <div class="menu-kiri-text">
                	<img src="../WEB-INF/images/nikah.png" height="24" class="top" />Status Nikah
                </div>
                </a>
                
                <a href="#" id="pegawai_add_keluarga" class="menu-bg" onclick="executeOnClick('pegawai_add_keluarga');">
                <div class="menu-kiri-text">
                	<img src="../WEB-INF/images/keluarga.png" height="24" class="top" />Data Keluarga
                </div>
                </a>

                <a href="#" id="pegawai_add_perubahan_alamat" class="menu-bg" onclick="executeOnClick('pegawai_add_perubahan_alamat');">
                <div class="menu-kiri-text">
                	<img src="../WEB-INF/images/alamat.png" height="24" class="top" />Perubahan Alamat
                </div>
                </a>

                <a href="#" id="pegawai_add_hukuman" class="menu-bg" onclick="executeOnClick('pegawai_add_hukuman');">
                <div class="menu-kiri-text">
                	<img src="../WEB-INF/images/hukuman.png" height="24" class="top" />Hukuman
                </div>
                </a>
                
                <a href="#" id="pegawai_add_sertifikat" class="menu-bg" onclick="executeOnClick('pegawai_add_sertifikat');">
                <div class="menu-kiri-text">
                	<img src="../WEB-INF/images/sertifikat.png" height="24" class="top" />Sertifikat
                </div>
                </a>
                <?php /*?><a href="#" id="pegawai_add_puspel" class="menu-bg" onclick="executeOnClick('pegawai_add_puspel');">
                <div class="menu-kiri-text">
                	<img src="../WEB-INF/images/puspel.png" height="24" class="top" />Puspel
                </div>
                </a><?php */?>
            </div>
            
            
            
            <?php /*?><br />

            <a href="#" class="data" onclick="executeOnClick('pegawai_add_data');" style="background-position:bottom"></a>
            <a href="#" class="data" onclick="executeOnClick('pegawai_add_sk_calon_pegawai');"></a>
            <a href="#" class="data" onclick="executeOnClick('pegawai_add_sk_pegawai');"></a>
            <!-- ************* -->
            <a href="#" class="upload" onclick="executeOnClick('pegawai_add_jabatan');"></a>
            <a href="#" class="upload" onclick="executeOnClick('pegawai_add_pangkat');"></a>
            <a href="#" class="upload" onclick="executeOnClick('pegawai_add_penghasilan');"></a>
            <!--<a href="#" class="upload" onclick="executeOnClick('pegawai_add_tpp');"></a>
            <a href="#" class="upload" onclick="executeOnClick('pegawai_add_tunjangan');"></a>-->
            <a href="#" class="upload" onclick="executeOnClick('pegawai_add_jenis_pegawai');"></a>
            <a href="#" class="upload" onclick="executeOnClick('pegawai_add_pendidikan');"></a>
            <a href="#" class="upload" onclick="executeOnClick('pegawai_add_status_nikah');"></a>
            <a href="#" class="upload" onclick="executeOnClick('pegawai_add_keluarga');"></a>
            <a href="#" class="upload" onclick="executeOnClick('pegawai_add_puspel');"></a>
            <!--<a href="#" class="scan" onclick="executeOnClick('scan');"></a>--><?php */?>
		</td>
	</tr>
</table>
</div>
</div>
</body>

</html>