<?
/* *******************************************************************************************************
MODUL NAME 			: informasi Kategori
FILE NAME 			: informasi_kategori.php
AUTHOR				: Aon-Prog
VERSION				: 1.0 beta
MODIFICATION DOC	:
DESCRIPTION			: Halaman untuk menampilkan informasi kategori
******************************************************************************************************* */

include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/classes/base-inventaris/KalkulasiPenyusutanBd.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");

$reqPeriode = httpFilterGet("reqPeriode");

/* create objects */
$kalkulasi_penyusutan = new KalkulasiPenyusutanBd();
$isPosting = "0";
$reqBulan = substr($reqPeriode, 0, 2);
$reqTahun = substr($reqPeriode, 2, 4);

$tempTanggal = "15-".$reqBulan."-".$reqTahun;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Form Validation - jQuery EasyUI Demo</title>
    <link href="../WEB-INF/lib/easyui/themes/default/easyui.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" language="javascript" src="../WEB-INF/lib/DataTables-1.10.6/media/js/jquery.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="js/globalfunction.js"></script>
	<link href="../WEB-INF/css/begron.css" rel="stylesheet" type="text/css">
    <link href="../WEB-INF/css/admin.css" rel="stylesheet" type="text/css">
    <link href="../WEB-INF/lib/treeTable/doc/stylesheets/master2.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../WEB-INF/lib/treeTable/doc/javascripts/jquery.ui.js"></script>
    <link href="../WEB-INF/lib/treeTable/src/stylesheets/jquery.treeTable.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="../WEB-INF/lib/easyui/kalender-easyui.js"></script>
    <script type="text/javascript" src="../WEB-INF/lib/easyui/globalfunction.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
   
		  	  
	  $('#btnBuatJurnal').on('click', function () {
			
		if(confirm('Buat jurnal penyusutan backdate periode <?=getNamePeriode($reqPeriode)?> ?'))
		{  
			var jqxhr = $.get( "../json-inventaris/kalkulasi_penyusutan_jurnal_bd.php?reqPeriode=<?=$reqPeriode?>&reqTanggalTransaksi="+$("#reqTanggalTransaksi").datebox("getValue"), function(data) {
			  alert(data);
			  $("#btnBuatJurnal").hide();
			});	
		}		

	  });
	
    
    });
	
	$('#btnCetakBukti').on('click', function () {
	 		
	});
	
</script>

	<!-- COLORING GRID -->
    <link rel="stylesheet" type="text/css" href="../WEB-INF/lib/ColoringGrid/css/table-style.css">
	<script type="text/javascript" src="../WEB-INF/lib/ColoringGrid/js/ColoringGrid.js"></script>
    
    

</head> 
<body>
<div id="begron"><img src="../WEB-INF/images/bg-kanan.jpg" width="100%" height="100%" alt="Smile"></div>
<div id="wadah">
    <div id="judul-halaman">
                <span><img src="../WEB-INF/images/panah-judul.png"> Rincian Bukti Jurnal</span>
    </div>
    <form id="ff" method="post" novalidate>
    <div id="rincian-header">	
    	<table>
        	<tr>
            	<td>Periode</td>
                <td>:</td>
                <td><?=getNamePeriode($reqPeriode)?></td>    
            	<td style="width:100px"></td> 
            	<td>Tanggal Jurnal</td>
                <td>:</td>
                <td><input id="reqTanggalTransaksi" name="reqTanggalTransaksi" class="easyui-datebox" data-options="validType:'date'" value="<?=$tempTanggal?>" /></td>             
            </tr>
        </table>
        	<tr>
            	<td>Keterangan</td>
                <td>:</td>
                <td>PENYUSUTAN ASSET BLM PROSES PERIODE <?=strtoupper(getNamePeriode($reqPeriode))?></td>    
             </tr>
    </div>
    
    <div id="rincian-table">
    <table id="table-gaya" width="100%" border="0" cellspacing="0" cellpadding="0">
    <thead>
      <tr>
          <th rowspan="2">Buku&nbsp;Besar</th>
          <th rowspan="2">Kartu</th>
          <th rowspan="2">Buku Pusat</th>
          <th rowspan="2">Keterangan</th>
          <th colspan="2">Rupiah</th>
      </tr>
	  <tr>
      	 <th>Debet</th>
      	 <th>Kredit</th>
      </tr>
    </thead>
    <tbody> 
	  <?
	  $i = 1;
	  $checkbox_index = 0;
	  $kalkulasi_penyusutan->selectByParamsJurnal(array("PERIODE"=>$reqPeriode));
	  $saldo_val_debet = 0;
	  $saldo_val_kredit = 0;
	  $saldo_rp_debet = 0;
	  $saldo_rp_kredit = 0;
	  
      while($kalkulasi_penyusutan->nextRow())
	  {
      ?>
          <tr id="node-<?=$i?>">
              <td>
              	<?=$kalkulasi_penyusutan->getField("KD_BUKU_BESAR")?>
              </td>
              <td>
              	00000
              </td>
              <td>
              	<?=$kalkulasi_penyusutan->getField("KD_BUKU_PUSAT")?>
              </td>
              <td>
              	<?=$kalkulasi_penyusutan->getField("NM_BUKU_BESAR")?>
              </td>
              <td align="right">
              	<?=numberToIna($kalkulasi_penyusutan->getField('DEBET'))?>
              </td>
              <td align="right">
              	<?=numberToIna($kalkulasi_penyusutan->getField('KREDIT'))?>
              </td>
           </tr>
      <?
	  	$i++;
		$checkbox_index++;
		$saldo_rp_debet += $kalkulasi_penyusutan->getField('DEBET');
        $saldo_rp_kredit += $kalkulasi_penyusutan->getField('KREDIT');
		$isPosting = $kalkulasi_penyusutan->getField("POSTING");
      }
      ?>
    </tbody>            
    <tfoot>
      	<td class="group_sum" colspan="4" style="text-align:right"><strong>Keseimbangan</strong></td>
        <td class="group_sum" align="right"><strong><?=numberToIna($saldo_rp_debet)?></strong></td>
        <td class="group_sum" align="right"><strong><?=numberToIna($saldo_rp_kredit)?></strong></td>
    </tfoot>
    </table>
    <br>
	<?
    if($isPosting == "1")
	{}
	else
	{
	?>
	<div style="width:100%; text-align:center;">
    
    	<input type="button" name="btnBuatJurnal" id="btnBuatJurnal" value="Buat Jurnal">
	</div>
    <?
	}
	?>
	</form>
    <div style="width:100%; text-align:center; text-decoration:blink">
    <strong><?=$hasil?></strong>
    </div>
</div>
<script>
$('input[id^="reqJumlah"]').keypress(function(e) {
	if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
	{
	return false;
	}
});
</script>
</body>
</html>