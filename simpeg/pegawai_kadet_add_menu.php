<?
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-simpeg/Pegawai.php");
include_once("../WEB-INF/classes/base-simpeg/PegawaiJenisPegawai.php");

$reqId = httpFilterRequest("reqId");

if($reqId == ""){}
else
{
	$pegawai_jenis_pegawai = new PegawaiJenisPegawai();
	$pegawai = new Pegawai();
	
	$pegawai->selectByParams(array("A.PEGAWAI_ID" => $reqId));
	$pegawai->firstRow();
	
	$tempNIS = $pegawai->getField('NIS');
	$tempNama = $pegawai->getField('NAMA');
	$tempZodiac = getZodiac((int)getDay($pegawai->getField("TANGGAL_LAHIR")), (int)getMonth($pegawai->getField("TANGGAL_LAHIR")));
	
	$pegawai_jenis_pegawai->selectByParamsKadet(array("PEGAWAI_ID"=>$reqId),-1,-1);
	$pegawai_jenis_pegawai->firstRow();
	$tempTanggalAwal= dateToPageCheck($pegawai_jenis_pegawai->getField("TANGGAL_KONTRAK_AWAL"));
	$tempTanggalAkhir= dateToPageCheck($pegawai_jenis_pegawai->getField("TANGGAL_KONTRAK_AKHIR"));
	$tempAsalSekolah= $pegawai->getField("DEPARTEMEN");
	$tempKelasSekolah= $pegawai_jenis_pegawai->getField("KELAS_SEKOLAH");
	$tempJurusanSekolah= $pegawai_jenis_pegawai->getField("JURUSAN");
}
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
$('a').css({'background-position': 'top'});

if(varItem == 'pegawai_add_data'){
	$('#pegawai_add_data').css({'background-position': '0 -27px'});
	parent.mainFramePop.location.href='pegawai_kadet_add_data.php?reqId=<?=$reqId?>';
	parent.document.getElementById('trdetil').style.display = 'none';	
}
else if(varItem == 'pegawai_kadet_add_jenis_pegawai'){
	$('#pegawai_kadet_add_jenis_pegawai').css({'background-position': '0 -27px'});
	parent.mainFramePop.location.href='pegawai_kadet_add_jenis_pegawai_monitoring.php?reqId=<?=$reqId?>';
	parent.mainFrameDetilPop.location.href='pegawai_kadet_add_jenis_pegawai.php?reqId=<?=$reqId?>';
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

<body leftmargin="5" rightmargin="0" bottommargin="0" topmargin="0" style="overflow-x:hidden;" >
<div id="page_effect" style="display:none;">
<div id="bg"><img src="../WEB-INF/images/bg-kiri-popup.jpg" width="100%" height="100%" alt=""></div>
<div id="content">
<table border="0" cellpadding="0" cellspacing="0" width="240" height="100%">
	<tr>
		<td>
        	<? if($reqId == ''){}else{?>
        	<div style="background-image:url(../WEB-INF/images/bg-identitas.png)">
            	<div id="menu-kiri-title-identitas">IDENTITAS</div>
				
                <div class="identitas-area">
                    <div class="identitas-foto">
                    	<img src="image_script.php?reqPegawaiId=<?=$reqId?>&reqMode=pegawai" width="50" height="66">
                    </div>
    
                    <div class="identitas-data"> 
                        <div><?=$tempNama?></div>     
                        <div>NIS : <?=$tempNIS?></div>
                        <div>Kelas : <?=$tempKelasSekolah?></div>
                    </div>
                    <div class="identitas-jabatan"><?=$tempAsalSekolah?></div>
                        
                    </div>
                </div>
                
                
			</div>            
            <? }?>
            
            <div id="menu-kiri">

            	<div id="menu-kiri-title">FIP 01</div>
                <a href="#" id="pegawai_add_data" class="menu-bg" onclick="executeOnClick('pegawai_add_data');" style="background-position:0 -27px">
                <div class="menu-kiri-text">
                	<img src="../WEB-INF/images/icn-menu-siswa.png" height="24" class="top" />Data Siswa
                </div>
                </a>          
                <a href="#" id="pegawai_kadet_add_jenis_pegawai" class="menu-bg" onclick="executeOnClick('pegawai_kadet_add_jenis_pegawai');">
                <div class="menu-kiri-text">
                	<img src="../WEB-INF/images/icn-menu-jenis-peg.png" height="24" class="top" />Histori Kelas
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