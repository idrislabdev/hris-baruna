<?php
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrKeyTabel.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/SafmBank.php");

$kbbr_key_table  = new KbbrKeyTabel();
$safm_bank = new SafmBank();

$kbbr_key_table->selectByParams(array("KD_SUBSIS" => "ALL", "ID_TABEL" => "OFFICER"));
$safm_bank->selectByParams(array(), -1, -1, "", " ORDER BY MBANK_KODE_BB ASC ");

$i=0;
while($kbbr_key_table->nextRow())
{
	$officer[$i]["KD_TABEL"] = $kbbr_key_table->getField("KD_TABEL");
	$officer[$i]["NM_KET1"] = $kbbr_key_table->getField("NM_KET1");
	$officer[$i]["NM_KET2"] = $kbbr_key_table->getField("NM_KET2");	
	$officer[$i]["NM_KET3"] = $kbbr_key_table->getField("NM_KET3");	
	$i++;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
<title>laporan harian kartu rekening</title>
<link rel="shortcut icon" type="image/ico" href="http://www.datatables.net/media/images/favicon.ico">
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://www.datatables.net/rss.xml">
<link href="../WEB-INF/css/admin.css" rel="stylesheet" type="text/css">

<link href="../WEB-INF/lib/media/themes/main_datatables.css" rel="stylesheet" type="text/css" /> 
<link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">  
<link rel="stylesheet" type="text/css" href="css/bluetabs.css" />
<link href="../WEB-INF/lib/easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>    
<script type="text/javascript" src="../WEB-INF/lib/easyui/kalender.js"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready( function () {

			  var periode = 'tanggal';

			  $(".periode").change(function () {
			  
				  var val = $('.periode:checked').val();
				  periode = val;
			  });				  

			  $('#btnCetak').live('click', function () {
			  	newWindow = window.open('laporan_harian_kartu_rekening_rpt.php?reqTanggal='+ $('#reqTanggal').datebox('getValue') +'&reqRekening='+ $("#reqRekening").val() +'&reqPeriode=' + periode + '&reqPejabatKiri='+ $("#reqPejabatKiri").val()+'&reqPejabatKanan='+ $("#reqPejabatKanan").val(), 'Cetak');
				newWindow.focus();
			  });	
			  
			  $('#btnExcel').live('click', function () {
			  	newWindow = window.open('laporan_harian_kartu_rekening_excel.php?reqTanggal='+ $('#reqTanggal').datebox('getValue') +'&reqRekening='+ $("#reqRekening").val() +'&reqPeriode=' + periode + '&reqPejabatKiri='+ $("#reqPejabatKiri").val()+'&reqPejabatKanan='+ $("#reqPejabatKanan").val(), 'Cetak');
				newWindow.focus();
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Rincian Laporan Kartu Rekening</span>
            </div>            
            </td>
        </tr>
    </table>

	<table>
		<tr>
        	<td>Tanggal Transaksi</td>
            <td><input id="reqTanggal" name="" class="easyui-datebox" data-options="validType:'date'" /></td>
        </tr>
        <tr>
        	<td>Rekening</td>
            <td>
            	<select id="reqRekening">
                <?
                while($safm_bank->nextRow())
				{
				?>
                	<option value="<?=$safm_bank->getField("MBANK_KODE_BB")?> <?=$safm_bank->getField("MBANK_KARTU_BB")?>-<?=$safm_bank->getField("MBANK_NAMA")?>"><?=$safm_bank->getField("MBANK_KODE_BB")?> <?=$safm_bank->getField("MBANK_KARTU_BB")?></option>
                <?
				}
				?>
                </select>
            </td>
        </tr>
        <tr>
        	<td>Periode</td>
            <td><input type="radio" class="periode" name="reqPeriode" value="tanggal" checked> Tanggal <input type="radio" class="periode" name="reqPeriode" value="bulan"> Bulan</td>
        </tr>
        <tr>           
             <td>Pejabat Kiri</td>
			 <td>
				<select id="reqPejabatKiri">
                	<?
                    for($i=0;$i<count($officer);$i++)
					{
					?>
                    	<option value="<?=$officer[$i]["NM_KET1"]?>" <? if($officer[$i]["KD_TABEL"] == "MAN") { ?> selected <? } ?>><?=$officer[$i]["NM_KET1"]?></option>
                    <?	
					}
					?>
                </select>
             </td>			
        </tr>
        <tr>           
             <td>Pejabat Kanan</td>
			 <td>
				<select id="reqPejabatKanan">
                	<?
                    for($i=0;$i<count($officer);$i++)
					{
					?>
                    	<option value="<?=$officer[$i]["NM_KET1"]?>" <? if($officer[$i]["KD_TABEL"] == "ASSMANKEU") { ?> selected <? } ?>><?=$officer[$i]["NM_KET1"]?></option>
                    <?	
					}
					?>
                </select>
             </td>			
        </tr>   
        <tr>
        	<td colspan="3"><input type="button" id="btnCetak" value="Cetak"><input type="button" id="btnExcel" value="Excel"></td>
        </tr>           
    </table>    	   
</div>
</body>
</html>

