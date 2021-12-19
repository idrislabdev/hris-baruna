<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrThnBukuD.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrKeyTabel.php");



/* LOGIN CHECK */

$kbbr_thn_buku_d = new KbbrThnBukuD();

$kbbr_thn_buku_d->selectByParams(array(), -1, -1, " ", " ORDER BY THN_BUKU DESC, BLN_BUKU DESC ");
$j=0;
while($kbbr_thn_buku_d->nextRow())
{
	$buku[$j]["BLN_BUKU"] = $kbbr_thn_buku_d->getField("BLN_BUKU");
	$buku[$j]["THN_BUKU"] = $kbbr_thn_buku_d->getField("THN_BUKU");
	$buku[$j]["NM_BLN_BUKU"] = $kbbr_thn_buku_d->getField("NM_BLN_BUKU");	
	$j++;
}


$kbbr_key_table  = new KbbrKeyTabel();
$kbbr_key_table->selectByParams(array("KD_SUBSIS" => "ALL", "ID_TABEL" => "OFFICER"));
$i=0;
while($kbbr_key_table->nextRow())
{
	$officer[$i]["KD_TABEL"] = $kbbr_key_table->getField("KD_TABEL");
	$officer[$i]["NM_KET1"] = $kbbr_key_table->getField("NM_KET1");
	$officer[$i]["NM_KET2"] = $kbbr_key_table->getField("NM_KET2");	
	$officer[$i]["NM_KET3"] = $kbbr_key_table->getField("NM_KET3");	
	$i++;
}
	
$tinggi = 155;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
<title>proses tutup tahun buku</title>
<link rel="shortcut icon" type="image/ico" href="http://www.datatables.net/media/images/favicon.ico">
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://www.datatables.net/rss.xml">

<!--<link href="../WEB-INF/lib/easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
<link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
<link href="../WEB-INF/lib/treeTable/doc/stylesheets/master2.css" rel="stylesheet" type="text/css" />
<link href="../WEB-INF/lib/treeTable/src/stylesheets/jquery.treeTable.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../WEB-INF/lib/DHTMLWindow/windowfiles/dhtmlwindow.css" type="text/css" />-->

<link href="../WEB-INF/css/admin.css" rel="stylesheet" type="text/css">

<style type="text/css" media="screen">
	@import "../WEB-INF/lib/media/css/site_jui.css";
    @import "../WEB-INF/lib/media/css/demo_table_jui.css";
    @import "../WEB-INF/lib/media/css/themes/base/jquery-ui.css";
    /*
     * Override styles needed due to the mix of three different CSS sources! For proper examples
     * please see the themes example in the 'Examples' section of this site
     */
    .dataTables_info { padding-top: 0; }
    .dataTables_paginate { padding-top: 0; }
    .css_right { float: right; }
    #example_wrapper .fg-toolbar { font-size: 0.7em }
    #theme_links span { float: left; padding: 2px 10px; }
	.libur { background-color:#F33; }
	.cuti { background-color:#FF0; }
	.ijin { background-color:#0F0; }	
</style>

<link href="../WEB-INF/lib/easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>    
<script type="text/javascript" src="../WEB-INF/lib/easyui/kalender.js"></script>

<script type="text/javascript" charset="utf-8">
$(document).ready( function () {
	
		$('#btnCetak').on('click', function () {
			if($("#reqJenisLaporan").val() == "LB1")
			{
				$.getJSON('../json-keuangansiuk/neraca_komparatif_proses_json.php?reqPeriode='+ $("#reqPeriode").val(),
				  function(data){
					newWindow = window.open('neraca_komparatif_rpt.php?reqPeriode='+ $("#reqPeriode").val()+'&reqPejabatKiri='+ $("#reqPejabatKiri").val()+'&reqPejabatKanan='+ $("#reqPejabatKanan").val(), 'Cetak');
					newWindow.focus();												
				});	
			}
			else if($("#reqJenisLaporan").val() == "LB2")
			{
				$.getJSON('../json-keuangansiuk/jenis_biaya_kompar_proses_json.php?reqPeriode='+ $("#reqPeriode").val(),
				  function(data){
					newWindow = window.open('jenis_biaya_kompar_rpt.php?reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
					newWindow.focus();
				});					
			}
			else if($("#reqJenisLaporan").val() == "LB2.1")
			{
				$.getJSON('../json-keuangansiuk/jenis_biaya_proses_json.php?reqPeriode='+ $("#reqPeriode").val(),
				  function(data){
					newWindow = window.open('jenis_biaya_rpt.php?reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
					newWindow.focus();
				});					
			}
			else if($("#reqJenisLaporan").val() == "LB3")
			{
				$.getJSON('../json-keuangansiuk/pusat_biaya_kompar_proses_json.php?reqPeriode='+ $("#reqPeriode").val(),
				  function(data){
					newWindow = window.open('pusat_biaya_kompar_rpt.php?reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
					newWindow.focus();
				});			
			}
			else if($("#reqJenisLaporan").val() == "LB4")
			{
				$.getJSON('../json-keuangansiuk/arus_kas_proses_json.php?reqPeriode='+ $("#reqPeriode").val(),
				  function(data){
					newWindow = window.open('arus_kas_rpt.php?reqPeriode='+ $("#reqPeriode").val()+'&reqPejabatKiri='+ $("#reqPejabatKiri").val(), 'Cetak');
					newWindow.focus();
				});		
			}
			else if($("#reqJenisLaporan").val() == "LB5")
			{
				$.getJSON('../json-keuangansiuk/rasio_keuangan_proses_json.php?reqPeriode='+ $("#reqPeriode").val(),
				  function(data){
					newWindow = window.open('rasio_keuangan_rpt.php?reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
					newWindow.focus();
				});	
			}
			else if($("#reqJenisLaporan").val() == "LB6")
			{
				newWindow = window.open('neraca_saldo_rpt.php?reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				newWindow.focus();	
			}
			else if($("#reqJenisLaporan").val() == "LB7")
			{
				newWindow = window.open('buku_besar_per_rekening_rpt.php?reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				newWindow.focus();
			}
			else if($("#reqJenisLaporan").val() == "LB8")
			{
				newWindow = window.open('ikhtisar_buku_besar_rpt.php?reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				newWindow.focus();
			}
			else if($("#reqJenisLaporan").val() == "LB9")
			{
				newWindow = window.open('ikhtisar_buku_bantu_rpt.php?reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				newWindow.focus();
			}
			else if($("#reqJenisLaporan").val() == "LB10")
			{
				newWindow = window.open('realisasi_anggaran_pendapatan_rpt.php?reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				newWindow.focus();
			}
			else if($("#reqJenisLaporan").val() == "LB11")
			{
				newWindow = window.open('realisasi_anggaran_biaya_jenis_rpt.php?reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				newWindow.focus();
			}
			else if($("#reqJenisLaporan").val() == "LB12")
			{
				newWindow = window.open('realisasi_anggaran_biaya_pusat_rpt.php?reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				newWindow.focus();
			}
			else if($("#reqJenisLaporan").val() == "LB13")
			{
				newWindow = window.open('realisasi_biaya_jenis_pusat_rpt.php?reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				newWindow.focus();
			}
			else if($("#reqJenisLaporan").val() == "LB14")
			{
				newWindow = window.open('realisasi_biaya_pusat_jenis_rpt.php?reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				newWindow.focus();
			}
	    });
		
		$('#btnExcel').on('click', function () {
			if($("#reqJenisLaporan").val() == "LB1")
			{
				$.getJSON('../json-keuangansiuk/neraca_komparatif_proses_json.php?reqPeriode='+ $("#reqPeriode").val(),
				  function(data){
					newWindow = window.open('neraca_komparatif_excel.php?reqPeriode='+ $("#reqPeriode").val()+'&reqPejabatKiri='+ $("#reqPejabatKiri").val()+'&reqPejabatKanan='+ $("#reqPejabatKanan").val(), 'Cetak');
					newWindow.focus();
												
				});	
			}
			else if($("#reqJenisLaporan").val() == "LB2")
			{
				$.getJSON('../json-keuangansiuk/jenis_biaya_kompar_proses_json.php?reqPeriode='+ $("#reqPeriode").val(),
				  function(data){
					newWindow = window.open('jenis_biaya_kompar_excel.php?reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
					newWindow.focus();
				});					
			}
			else if($("#reqJenisLaporan").val() == "LB2.1")
			{
				$.getJSON('../json-keuangansiuk/jenis_biaya_proses_json.php?reqPeriode='+ $("#reqPeriode").val(),
				  function(data){
					newWindow = window.open('jenis_biaya_excel.php?reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
					newWindow.focus();
				});				
			}
			else if($("#reqJenisLaporan").val() == "LB3")
			{
				$.getJSON('../json-keuangansiuk/pusat_biaya_kompar_proses_json.php?reqPeriode='+ $("#reqPeriode").val(),
				  function(data){
					newWindow = window.open('pusat_biaya_kompar_excel.php?reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
					newWindow.focus();
				});		
			}
			else if($("#reqJenisLaporan").val() == "LB3.1")
			{
				$.getJSON('../json-keuangansiuk/pusat_biaya_proses_json.php?reqPeriode='+ $("#reqPeriode").val(),
				  function(data){
					newWindow = window.open('pusat_biaya_excel.php?reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
					newWindow.focus();
				});	
			}
			else if($("#reqJenisLaporan").val() == "LB4")
			{
				$.getJSON('../json-keuangansiuk/arus_kas_proses_json.php?reqPeriode='+ $("#reqPeriode").val(),
				  function(data){
					newWindow = window.open('arus_kas_excel.php?reqPeriode='+ $("#reqPeriode").val()+'&reqPejabatKiri='+ $("#reqPejabatKiri").val(), 'Cetak');
					newWindow.focus();
				});	
			}
			else if($("#reqJenisLaporan").val() == "LB5")
			{
				$.getJSON('../json-keuangansiuk/rasio_keuangan_proses_json.php?reqPeriode='+ $("#reqPeriode").val(),
				  function(data){
					newWindow = window.open('rasio_keuangan_excel.php?reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
					newWindow.focus();
				});	
			}
			else if($("#reqJenisLaporan").val() == "LB6")
			{
				newWindow = window.open('neraca_saldo_excel.php?reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				newWindow.focus();
			}
			else if($("#reqJenisLaporan").val() == "LB7")
			{
				newWindow = window.open('buku_besar_per_rekening_excel.php?reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				newWindow.focus();
			}
			else if($("#reqJenisLaporan").val() == "LB8")
			{
				newWindow = window.open('ikhtisar_buku_besar_excel.php?reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				newWindow.focus();
			}
			else if($("#reqJenisLaporan").val() == "LB9")
			{
				newWindow = window.open('ikhtisar_buku_bantu_excel.php?reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				newWindow.focus();
			}
			else if($("#reqJenisLaporan").val() == "LB10")
			{
				newWindow = window.open('realisasi_anggaran_pendapatan_excel.php?reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				newWindow.focus();
			}
			else if($("#reqJenisLaporan").val() == "LB11")
			{
				newWindow = window.open('realisasi_anggaran_biaya_jenis_excel.php?reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				newWindow.focus();
			}
			else if($("#reqJenisLaporan").val() == "LB12")
			{
				newWindow = window.open('realisasi_anggaran_biaya_pusat_excel.php?reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				newWindow.focus();
			}
			else if($("#reqJenisLaporan").val() == "LB13")
			{
				newWindow = window.open('realisasi_biaya_jenis_pusat_excel.php?reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				newWindow.focus();
			}
			else if($("#reqJenisLaporan").val() == "LB14")
			{
				newWindow = window.open('realisasi_biaya_pusat_jenis_excel.php?reqPeriode='+ $("#reqPeriode").val(), 'Cetak');
				newWindow.focus();
			}
	    });
		
		$("#reqJenisLaporan").change(function() { 
		    if($("#reqJenisLaporan").val() == "LB1")
			{
				$("#reqPejabatKanan").removeAttr("disabled");
				$("#reqPejabatKiri").removeAttr("disabled");
			}
		    else if($("#reqJenisLaporan").val() == "LB4")
			{
				$("#reqPejabatKanan").attr("disabled", "disabled");
				$("#reqPejabatKiri").removeAttr("disabled");
			}
			else
			{
				$("#reqPejabatKanan").attr("disabled", "disabled");
				$("#reqPejabatKiri").attr("disabled", "disabled");
			}						 	 
		});
} );
</script>

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
<link href="../WEB-INF/css/bluetabs.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../WEB-INF/css/dropdowntabs.js"></script>
<script language="JavaScript" src="../jslib/displayElement.js"></script>  

<style>
table.keu-pusat{
	border-collapse:collapse;
}
table.keu-pusat td{
	padding:10px;
	background:#8df0ef;
	margin:1px;
}
table.keu-pusat
{
border-collapse:collapse;
}
table.keu-pusat, table.keu-pusat th, table.keu-pusat td
{
border: 1px solid #a1f8f7;
}
table.keu-pusat th{
	background:#4cbfbe;
	color:#FFF;
	padding:10px ;
	text-transform:uppercase;
	font-weight:bold;
	text-shadow:0px 1px 2px #189190;
}
</style>
</head>
<body style="overflow:hidden">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td class="">
            <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> LAPORAN BULANAN</span>
            </div>            
            </td>
        </tr>
    </table>
    <div id="konten" class="border-frame">
    	<!--<div style="font-weight:bold;">Konversi Data Bulanan Keuangan SIUK<br>Untuk Kompilasi / Konsolidasi</div>
          <br>-->
          
          <table class="keu-pusat">
          	<form name="form1" method="post" action="">
            <tr>
              <th colspan="6">Cetak Semua Laporan Bulanan</th>
            </tr>
            <tr>
              <td colspan="6"> Periode :
                <select name="reqPeriode" id="reqPeriode">
                  	<?
                    for($j=0;$j<count($buku);$j++)
					{
					?>
                    	<option value="<?=$buku[$j]["BLN_BUKU"].$buku[$j]["THN_BUKU"]?>"><?=$buku[$j]["NM_BLN_BUKU"]."-".$buku[$j]["THN_BUKU"]?></option>
                    <?	
					}
					?>
                </select>
              &nbsp;&nbsp;</td>
            </tr>
            <tr>
            	<td colspan="6">
                	Jenis Laporan : 
                      <select name="reqJenisLaporan" id="reqJenisLaporan">
                      	<?
							for ($a=1; $a<=14; $a++)
							{ 
                        ?>
                        	<?
								if($a==2)
								{
                            ?>
						  		<option value="LB2">LB2</option>
						  		<option value="LB2.1">LB2.1</option>
                            <?
								}
								else if($a==3)
								{
							?>
						  		<option value="LB3">LB3</option>
						  		<option value="LB3.1">LB3.1</option>
							<?
								}
								else{
                            ?>
                            	<option value="LB<?=$a?>">LB<?=$a?></option>
                            <?
								}
                            ?>
					  	<?
							}
                        ?>
                      </select>&nbsp;&nbsp;</td>
           	</tr>
          	<tr>
            	<td colspan="6"><div style="text-align:center; margin-top:10px; margin-bottom:-60px;"><img src="../WEB-INF/images/horizontal-divider.png" width="600"></div></td>
            </tr>
          	<tr>
          	  <th colspan="6">Parameter</th>
            </tr>
          	<tr>
          	  <td>Pejabat Kiri</td>
          	  <td>:</td>
          	  <td>
              <select id="reqPejabatKiri">
                	<?
                    for($i=0;$i<count($officer);$i++)
					{
					?>
                    	<option value="<?=$officer[$i]["NM_KET1"]."-".$officer[$i]["NM_KET2"]?>" <? if($officer[$i]["KD_TABEL"] == "KACAB") { ?> selected <? } ?>><?=$officer[$i]["NM_KET1"]?></option>
                    <?	
					}
					?>
              </select>
              </td>
            </tr>
            <tr>  
          	  <td>Pejabat Kanan</td>
          	  <td>:</td>
          	  <td>
              <select id="reqPejabatKanan">
                	<?
                    for($i=0;$i<count($officer);$i++)
					{
					?>
                    	<option value="<?=$officer[$i]["NM_KET1"]."-".$officer[$i]["NM_KET2"]?>" <? if($officer[$i]["KD_TABEL"] == "MAN") { ?> selected <? } ?>><?=$officer[$i]["NM_KET1"]?></option>
                    <?	
					}
					?>
              </select>
              </td>
          	</tr>
          	<tr>
          	  <td colspan="6">
              	<div style="text-align:center; margin-top:20px; margin-bottom:-60px;"><img src="../WEB-INF/images/horizontal-divider.png" width="600"></div>
              </td>
        	  </tr>
          	<tr>
          	  <td colspan="6"><input type="button" id="btnCetak" name="btnCetak" value="Cetak"> <input type="button" id="btnExcel" name="btnExcel" value="Excel"></td>
          	  </tr>
          	</form>
          </table>
  </div>
</div>
</body>
</html>