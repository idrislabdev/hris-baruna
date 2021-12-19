<?php
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrThnBukuD.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrKeyTabel.php");

$reqNoBukti = httpFilterGet("reqNoBukti");

$kbbr_thn_buku_d  = new KbbrThnBukuD();
$kbbr_key_table  = new KbbrKeyTabel();

$kbbr_thn_buku_d->selectByParams(array(), -1, -1, "", " ORDER BY THN_BUKU DESC, TO_NUMBER(BLN_BUKU) DESC ");
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
<title>neraca komparatif</title>
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
				  newWindow = window.open('cetak_bukti_kompensasi_jrr_rpt.php?reqId='+ $("#reqNoBukti").val()+'&reqPejabatKiri='+ $("#reqPejabatKiri").val(), 'Cetak');
				  newWindow.focus();
				  window.parent.divwin.close();
				});
			  
			   $('#btnExcel').live('click', function () {
					newWindow = window.open('cetak_bukti_kompensasi_jrr_excel.php?reqId='+ $("#reqNoBukti").val()+'&reqPejabatKiri='+ $("#reqPejabatKiri").val(), 'Cetak');
					newWindow.focus();
				 	window.parent.divwin.close();		
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Transaksi Pelunasan Nota</span>
            </div>            
            </td>
        </tr>
    </table>

	<table>
        <tr>           
             <td>Nomor Bukti</td>
			 <td>
             	<input name="reqNoBukti" id="reqNoBukti" class="easyui-validatebox" style="width:170px" type="text" readonly value="<?=$reqNoBukti?>" />
             </td>			
        </tr>
        <tr>           
             <td>Penanda Tangan</td>
			 <td>
             	<select id="reqPejabatKiri">
                	<?
                    for($i=0;$i<count($officer);$i++)
					{
					?>
                    	<option value="<?=$officer[$i]["NM_KET1"].'-'.$officer[$i]["NM_KET3"]?>" <? if($officer[$i]["KD_TABEL"] == "MAN") { ?> selected <? } ?>><?=$officer[$i]["NM_KET1"]?></option>
                    <?	
					}
					?>
                </select>
             </td>			
        </tr>
        <tr>
        	<td colspan="3"><input type="button" id="btnCetak" value="Cetak"> <input type="button" id="btnExcel" value="Excel"></td>
        </tr>      
    </table>    	   
</div>
</body>
</html>

