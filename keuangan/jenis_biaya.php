<?php
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrThnBukuD.php");

$kbbr_thn_buku_d  = new KbbrThnBukuD();

$kbbr_thn_buku_d->selectByParams(array(), -1, -1, "", " ORDER BY THN_BUKU DESC, TO_NUMBER(BLN_BUKU) DESC ");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
<title>jenis biaya</title>
<link rel="shortcut icon" type="image/ico" href="http://www.datatables.net/media/images/favicon.ico">
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://www.datatables.net/rss.xml">
<link href="../WEB-INF/css/admin.css" rel="stylesheet" type="text/css">


<!--RIGHT CLICK EVENT-->		
<style>

	.vmenu{
	border:1px solid #aaa;
	position:absolute;
	background:#fff;
	display:none;font-size:0.75em;}
	.first_li{}
	.first_li span{width:100px;display:block;padding:5px 10px;cursor:pointer}
	.inner_li{display:none;margin-left:120px;position:absolute;border:1px solid #aaa;border-left:1px solid #ccc;margin-top:-28px;background:#fff;}
	.sep_li{border-top: 1px ridge #aaa;margin:5px 0}
	.fill_title{font-size:11px;font-weight:bold;/height:15px;/overflow:hidden;word-wrap:break-word;}

</style>
<link href="../WEB-INF/lib/media/themes/main_datatables.css" rel="stylesheet" type="text/css" /> 
<link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">  
<link rel="stylesheet" type="text/css" href="css/bluetabs.css" />
<script src="../WEB-INF/lib/media/js/jquery-1.4.4.min.js" type="text/javascript"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready( function () {
			  $('#btnCetak').live('click', function () {
				//alert('exec procedure WLAP_LABA_RUGI_BIAYA_PRT dulu!!! SAMA DENGAN KOMPAR CUMA BEDA CAPTION !!!');
				$.getJSON('../json-keuangansiuk/jenis_biaya_proses_json.php?reqPeriode='+ $("#reqPeriode").val()+'&reqCabang='+$("#reqCabang").val(),
				  function(data){
					newWindow = window.open('jenis_biaya_rpt.php?reqHalaman='+ $("#reqHalaman").val()+'&reqPeriode='+ $("#reqPeriode").val()+'&reqCabang='+$("#reqCabang").val(), 'Cetak');
					newWindow.focus();
				});				  	
			  });	
			  
			  
			   $('#btnExcel').live('click', function () {
				//alert('exec procedure WLAP_LABA_RUGI_BIAYA_PRT dulu!!! SAMA DENGAN KOMPAR CUMA BEDA CAPTION !!!');
				$.getJSON('../json-keuangansiuk/jenis_biaya_proses_json.php?reqPeriode='+ $("#reqPeriode").val(),
				  function(data){
					newWindow = window.open('jenis_biaya_excel.php?reqHalaman='+ $("#reqHalaman").val()+'&reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
					newWindow.focus();
				});				  	
			  });	
	});
</script>
</head>
<body style="overflow:hidden">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td class="">
            <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Laporan Aktivitas Kenaikan / Penurunan Jenis Biaya</span>
            </div>            
            </td>
        </tr>
    </table>

	<table>
        <tr>           
             <td>Periode Laporan</td>
			 <td>
             	<select id="reqPeriode" name="reqPeriode">
                	<?
                    while($kbbr_thn_buku_d->nextRow())
					{
					?>
                    	<option value="<?=$kbbr_thn_buku_d->getField("BLN_BUKU").$kbbr_thn_buku_d->getField("THN_BUKU")?>"><?=$kbbr_thn_buku_d->getField("NM_BLN_BUKU")?></option>
                    <?	
					}
					?>
                </select>
             </td>			
        </tr>   
        
        <?
        if($_GET["reqMode"] == "cabang")
		{
		?>
        <tr>           
             <td>Cabang</td>
			 <td>
             	<select id="reqCabang">
                	<?
					$kbbr_cabang  = new KbbrThnBukuD();
					$kbbr_cabang->selectByParamsKodeCabang();
                    while($kbbr_cabang->nextRow())
					{
					?>
                    	<option value="<?=$kbbr_cabang->getField("KODE_CABANG")?>"><?=$kbbr_cabang->getField("KODE_CABANG")?></option>
                    <?	
					}
					?>
                </select>
             </td>			
        </tr>          
       <?
		}
		else
		{
	   ?>
       	<input type="hidden" id="reqCabang">
       <?
		}
	   ?>

        <? /*
         */ ?>
        <tr>
        	<td>Halaman Awal</td>
            <td>
            	<input type="text" id="reqHalaman" style="width:80px" required value="1">
            </td>
        </tr> 
        <tr>
        	<td colspan="3"><input type="button" id="btnCetak" value="Cetak"><input type="button" id="btnExcel" value="Excel"></td>
        </tr>          
    </table>    
 <script>
 	$("#reqHalaman").keypress(function(e) {
		if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
		{
		return false;
		}
	});
 </script> 		   
</div>
</body>
</html>

