<?php
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrGeneralRefD.php");


$kbbr_general_ref_d = new KbbrGeneralRefD();

$kbbr_general_ref_d->selectByParams(array("ID_REF_FILE" => "JENISJURNAL"), -1, -1, "", "ORDER BY ID_REF_DATA ASC");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
<title>rincian mutasi jurnal bak</title>
<link rel="shortcut icon" type="image/ico" href="http://www.datatables.net/media/images/favicon.ico">
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://www.datatables.net/rss.xml">
<link href="../WEB-INF/css/admin.css" rel="stylesheet" type="text/css">

<link href="../WEB-INF/lib/media/themes/main_datatables.css" rel="stylesheet" type="text/css" /> 
<link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">  
<link rel="stylesheet" type="text/css" href="css/bluetabs.css" />
<link href="../WEB-INF/lib/easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery-1.6.1.min.js"></script>
<script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>  
<script type="text/javascript">
	$.fn.datebox.defaults.formatter = function(date) {
		var y = date.getFullYear();
		var m = date.getMonth() + 1;
		var d = date.getDate();
		return (d < 10 ? '0' + d : d) + '-' + (m < 10 ? '0' + m : m) + '-' + y;
	};
	
	$.extend($.fn.validatebox.defaults.rules, {
		date:{
			validator:function(value, param) {
				if(value.length == '10')
				{
					var reg = /^(\d{1,2})(-|\/)(\d{1,2})\2(\d{1,4})$/;
					return reg.test(value);
				}
				else
				{
					return false;
				}
			},
			message:"Format Tanggal: dd-mm-yyyy"
		}  
	});

	$.fn.datebox.defaults.parser = function(s) {
		if (s) {
			var a = s.split('-');
			var d = new Number(a[0]);
			var m = new Number(a[1]);
			var y = new Number(a[2]);
			var dd = new Date(y, m-1, d);
			return dd;
		} 
		else 
		{
			return new Date();
		}
	};
</script>

<script type="text/javascript" src="../WEB-INF/lib/easyui/kalender.js"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready( function () {
			  $('#btnCetak').on('click', function () {
			  	newWindow = window.open('rincian_mutasi_jurnal_rpt.php?reqStatusPosting='+ $("#reqStatusPosting").val() + "&reqTanggalMulai="+ $('#reqTanggalMulai').datebox('getValue') +"&reqTanggalAkhir="+ $('#reqTanggalAkhir').datebox('getValue') +"&reqJenisJurnal="+$("#reqJenisJurnal").val(), 'Cetak');
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
                <span><img src="../WEB-INF/images/panah-judul.png"> Rincian Mutasi Jurnal</span>
            </div>            
            </td>
        </tr>
    </table>

	<table>
 		<tr>
        	<td>Status Posting</td>
            <td>
            	<select id="reqStatusPosting">
                	<option value="BELUM POSTING">BELUM POSTING</option>
                    <option value="SUDAH POSTING">SUDAH POSTING</option>
                </select>
            </td>
        </tr>
		<tr>
        	<td>Tanggal Mulai</td>
            <td><input id="reqTanggalMulai" name="" class="easyui-datebox" data-options="validType:'date'" /></td>
        </tr>
		<tr>
        	<td>Tanggal Akhir</td>
            <td><input id="reqTanggalAkhir" name="" class="easyui-datebox" data-options="validType:'date'" /></td>
        </tr>
        <tr>
        	<td>Jenis Jurnal</td>
            <td>
            	<select id="reqJenisJurnal">
                <?
                while($kbbr_general_ref_d->nextRow())
				{
				?>
                	<option value="<?=$kbbr_general_ref_d->getField("ID_REF_DATA")?>-<?=$kbbr_general_ref_d->getField("KET_REF_DATA")?>"><?=$kbbr_general_ref_d->getField("ID_REF_DATA")?></option>
                <?
				}
				?>
                </select>
            </td>
        </tr>
        <tr>
        	<td colspan="3"><input type="button" id="btnCetak" value="Cetak"></td>
        </tr>          
    </table>    	   
</div>
</body>
</html>

