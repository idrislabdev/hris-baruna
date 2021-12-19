<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrThnBukuD.php");



/* LOGIN CHECK */

$kbbr_thn_buku_d = new KbbrThnBukuD();

$kbbr_thn_buku_d->selectByParams(array(), -1, -1, " ", " ORDER BY THN_BUKU DESC, BLN_BUKU DESC ");
while($kbbr_thn_buku_d->nextRow())
{
	$arrPeriode[] = $kbbr_thn_buku_d->getField("PERIODE");	
	$arrPeriodeNama[] = $kbbr_thn_buku_d->getField("NM_BLN_BUKU");
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
	
		$('#btnProses').on('click', function () {
			var win = $.messager.progress({
				title:'Please waiting',
				msg:'Loading data...'
			});
			
			$.getJSON('../json-keuangansiuk/create_file_keu_pusat_json.php?reqTahunBuku='+$('#reqTahunBuku').val()+'&reqTahunBukuAkhir='+$('#reqTahunBukuAkhir').val(),
			  function(data){
				$.messager.progress('close');
				alert(data.PESAN);	
			});		
	    });
		
		$('#btnMasterFoxpro').on('click', function () {
				  newWindow = window.open('knv_tmp_master_foxpro_excel.php?reqTahunBuku='+$('#reqTahunBuku').val()+'&reqTahunBukuAkhir='+$('#reqTahunBukuAkhir').val(), 'Cetak');
				  newWindow.focus();
		});
		
		$('#btnTranbFoxpro').on('click', function () {
				  newWindow = window.open('knv_tmp_tranb_foxpro_excel.php?reqTahunBuku='+$('#reqTahunBuku').val()+'&reqTahunBukuAkhir='+$('#reqTahunBukuAkhir').val(), 'Cetak');
				  newWindow.focus();
		});
		
		$('#btnPiutangMaster').on('click', function () {
				  newWindow = window.open('knv_tmp_piutang_master_excel.php?reqTahunBuku='+$('#reqTahunBuku').val()+'&reqTahunBukuAkhir='+$('#reqTahunBukuAkhir').val(), 'Cetak');
				  newWindow.focus();
		});
		
		$('#btnMastersMach').on('click', function () {
				  newWindow = window.open('knv_tmp_masters_mach_excel.php?reqTahunBuku='+$('#reqTahunBuku').val()+'&reqTahunBukuAkhir='+$('#reqTahunBukuAkhir').val(), 'Cetak');
				  newWindow.focus();
		});
		
		$('#btnControlData').on('click', function () {
				  newWindow = window.open('knv_tmp_controldata_foxpro_excel.php?reqTahunBuku='+$('#reqTahunBuku').val()+'&reqTahunBukuAkhir='+$('#reqTahunBukuAkhir').val(), 'Cetak');
				  newWindow.focus();
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

</head>
<body style="overflow:hidden">
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td class="">
            <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Create File Keuangan Pusat</span>
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
              <th colspan="3">Konversi Data Bulanan Keuangan SIUK Untuk Kompilasi / Konsolidasi</th>
            </tr>
            <tr>
            	<td colspan="3">
                	Periode Dari : 
                    <select name="reqTahunBuku" id="reqTahunBuku">
					<?
                    for($i=0; $i<count($arrPeriode); $i++)
                    {
                    ?>
                        <option value="<?=$arrPeriode[$i]?>"><?=$arrPeriodeNama[$i]?></option>
                    <?
                    }
                    ?>
                    </select>&nbsp;&nbsp;
                	Sampai : 
                    <select name="reqTahunBukuAkhir" id="reqTahunBukuAkhir">
					<?
                    for($i=0; $i<count($arrPeriode); $i++)
                    {
                    ?>
                        <option value="<?=$arrPeriode[$i]?>"><?=$arrPeriodeNama[$i]?></option>
                    <?
                    }
                    ?>
                    </select>&nbsp;&nbsp;
                    <input type="button" id="btnProses" name="btnProses" value="Proses">
                </td>
           	</tr>
          	<tr>
            	<td colspan="3"><div style="text-align:center; margin-top:10px; margin-bottom:-60px;"><img src="../WEB-INF/images/horizontal-divider.png" width="600"></div></td>
            </tr>
          	<tr>
            	<td width="153">Output Akuntansi</td>
            	<td width="3">:</td>
            	<td width="502"><a" id="btnMasterFoxpro" name="btnMasterFoxpro" value="Export Excel"><img src="images/excel.png"></a> MSTR</td>
            </tr>
          	<tr>
            	<td>&nbsp;</td>
            	<td>&nbsp;</td>
            	<td><a" id="btnTranbFoxpro" name="btnTranbFoxpro" value="Export Excel"><img src="images/excel.png"></a> TRAN</td>
            </tr>
          	<tr>
            	<td>Output Kartu Piutang</td>
            	<td>:</td>
            	<td><a" id="btnPiutangMaster" name="btnPiutangMaster" value="Export Excel"><img src="images/excel.png"></a> PIUT</td>
            </tr>
          	<tr>
            	<td>Output Master</td>
            	<td>:</td>
            	<td><a" id="btnMastersMach" name="btnMastersMach" value="Export Excel"><img src="images/excel.png"></a> TABEL<br><div style="color:#189190; font-size:13px;">(Rekening, Puspel, Pelanggan)</div></td>
            </tr>
          	<tr>
            	<td>Control Data</td>
            	<td>:</td>
            	<td><a" id="btnControlData" name="btnControlData" value="Export Excel"><img src="images/excel.png"></a> CTRL</td>
            </tr>
          	<tr>
            	<td colspan="3"><div style="text-align:center; margin-top:20px; margin-bottom:-60px;"><img src="../WEB-INF/images/horizontal-divider.png" width="600"></div></td>
            </tr>
            </form>
          </table>
          
          
          
          <?php /*?><form name="form1" method="post" action="">
            <p>
              <label>
                <input type="checkbox" name="ch1" value="checkbox" id="ch1" value="proses1">
                1. Memindahkan Saldo Neraca Desember tahun terpilih ke Saldo Neraca Awal tahun berikut.</label>
              <br>
              <label>
                <input type="checkbox" name="ch2" value="checkbox" id="ch2" value="proses2">
                2. Membuat 2 Jurnal (JRR) Tutup Tahun.</label>
              <br>
              <label>
                <input type="checkbox" name="ch3" value="checkbox" id="ch3" value="proses3">
                3. Memindahkan rekening dan saldo Anggaran tahun lalu ke tahun berikutnya.</label>
              <br>
            </p>
            
            <div style="text-align:center; margin-top:20px;"><img src="../WEB-INF/images/horizontal-divider.png"></div>
            <div style="font-weight:bold; margin-top:-80px;">Perhatikan :</div><br>
            1. Semua transaksi sebelumnya sudah diposting.<br>
            2. Semua laporan bulanan sebelumnya sudah ok dan sudah diclose.<br>
            3. Proses hanya bisa dilakukan sebelum laporan bulan Januari tahun depan dicetak.<br>
            
            <div style="text-align:center; margin-top:20px;"><img src="../WEB-INF/images/horizontal-divider.png"></div>
            <div style=" text-align:center; padding:20px; background:; margin:-80px 0 20px; color:#4a5e70;">
            	<div style="font-weight:bold;">Tutup Neraca untuk Tahun Laporan :</div><br>
                <select name="reqTahunBuku" id="reqTahunBuku">
                <?
                for($i=0; $i<count($arrPeriode); $i++)
				{
				?>
                	<option value="<?=$arrPeriode[$i]?>"><?=$arrPeriodeNama[$i]?></option>
                <?
				}
				?>
                </select>
            </div>
            <div style="text-align:center;">
                <input type="button" id="btnBatal" name="btnBatal" value="Batal Proses">
                <input type="button" id="btnProses" name="btnProses" value="Proses">
            </div>
          </form><?php */?>
  </div>
</div>
</body>
</html>