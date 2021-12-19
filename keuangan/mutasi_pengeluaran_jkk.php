<?php
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrKeyTabel.php");

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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
<title>laporan harian mutasi kas bank</title>
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
			  	newWindow = window.open('mutasi_pengeluaran_jkk_rpt.php?reqTanggal='+ $('#reqTanggal').datebox('getValue') +'&reqPeriode=' + periode + '&reqValuta=' + $("#reqValuta").val(), 'Cetak');
				newWindow.focus();
			  });	
			  
			  $('#btnExcel').live('click', function () {
			  	newWindow = window.open('mutasi_pengeluaran_jkk_excel.php?reqTanggal='+ $('#reqTanggal').datebox('getValue') +'&reqPeriode=' + periode + '&reqValuta=' + $("#reqValuta").val(), 'Cetak');
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Rincian Mutasi Pengeluaran JKK</span>
            </div>            
            </td>
        </tr>
    </table>

	<table>
		<tr>
        	<td>Tanggal</td>
            <td><input id="reqTanggal" name="" class="easyui-datebox" data-options="validType:'date'" /></td>
        </tr>
        <tr>           
             <td>Valuta</td>
			 <td>
				<select id="reqValuta">
                	<option value="IDR">IDR</option>
                    <option value="USD">USD</option>
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

