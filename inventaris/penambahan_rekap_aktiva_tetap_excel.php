<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");
include_once("../WEB-INF/classes/base-inventaris/KalkulasiPenyusutan.php");

$kalkulas_penyusutan = new KalkulasiPenyusutan();

$reqPeriode = httpFilterGet("reqPeriode");

ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=rincian_rekap_aktiva_tetap.xls");

if($reqPeriode == "")
  $reqPeriode = '0';
$statement_privacy = " AND PERIODE = '".$reqPeriode."'";
$sOrder = " ";

$kalkulas_penyusutan->selectByParamsRekapAktiva(array(), -1, -1, $statement_privacy, $sOrder);        

?>

<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
        <script>
		document.onkeydown = function(e) {
			if(e.keyCode == 123) {
			 return false;
			}
			if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)){
			 return false;
			}
			if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)){
			 return false;
			}
			if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)){
			 return false;
			}
		
			if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)){
			 return false;
			}      
		 }		
		</script>
	</head>
    
	<body oncontextmenu="return false;">
    
    <!-- <table class="area-kop-slip">
    	<tr>
    	<?
		if($reqExcel == "1")
		{}
		else
		{
		?>
        	<td rowspan="3" width="100px"><img src="images/PJB-PNG.png" class="logo-slip"></td>
        <?
		}
		?>
        	<td colspan="10"><strong>PT PJB</strong></td>
        </tr>
    	<tr>
    	  <td colspan="10">Jl. Ketintang Baru No. 11. Surabaya (60231) Jawa Timur, Indonesia</td>
  	  </tr>
    	<tr>
    	  <td colspan="10">Telp. (62-31) 8283180 Fax. (62-31) 8283183</td>
  	  </tr>
	</table>
    
    
    <div class="area-keterangan-slip">
    	<div align="center"><b>LAPORAN PREMI SHIFT<br>
         Periode <?=getNamePeriode($reqPeriode)?></b></div>
    </div>
    <div  class="area-data-slip">
         <div class="atas" align="left">Status : <?=$reqStatusPegawaiNama?></div>
        <div class="bawah" align="left">Cabang : <?=$reqDepartemenNama?> </div>
    </div>     -->
   <div class="area-keterangan-slip">
    	<div align="center"><b>RINCIAN REKAPITULASI AKTIVA TETAP<br>
         Periode <?=getNamePeriode($reqPeriode)?></b><br></div>
    </div>
 
    <table class="area-data-slip" border="1">
    	<tr>
            <th style="width:400px">KODE</th>          
            <th width="50px">LOKAS</th>          
            <th width="50px">NAMA AKTIVA</th>          
            <th width="50px">SPESIFIKASI</th>            
            <th width="50px">TANGGAL PEROLEHAN</th>           
            <th width="50px">SISA UMUR</th>   
            <th width="50px">HARGA PEROLEHAN</th>   
            <th width="50px">AKM PENYUSUTAN LALU</th>   
            <th width="50px">PENYUSUTAN S.D <?=strtoupper(getNamePeriode($reqPeriode))?></th>   
            <th width="50px">AKM PENYUSUTAN</th>   
            <th width="50px">NILAI BUKU</th>   
        </tr>
      <?
	  $no= 1;
	  $header = "";
	  while($kalkulas_penyusutan->nextRow())
	  {

	  	if($header == $kalkulas_penyusutan->getField("HEADER"))
	  	{}
		else
		{
			?>
	      	<tr>
	      		<td colspan="11"><?=$kalkulas_penyusutan->getField("HEADER")?></td>
	      	</tr>
			<?
		}
		$header = $kalkulas_penyusutan->getField("HEADER");
		?>
      	<tr>
        	<td><?=$kalkulas_penyusutan->getField("KODE")?></td>
        	<td><?=$kalkulas_penyusutan->getField("LOKAS")?></td>
        	<td><?=$kalkulas_penyusutan->getField("NAMA")?></td>
        	<td><?=$kalkulas_penyusutan->getField("SPESIFIKASI")?></td>
        	<td><?=$kalkulas_penyusutan->getField("TANGGAL_PEROLEHAN")?></td>
        	<td><?=numberToIna($kalkulas_penyusutan->getField("SISA_UMUR"))?></td>
        	<td><?=numberToIna($kalkulas_penyusutan->getField("NILAI_PEROLEHAN"))?></td>
        	<td><?=numberToIna($kalkulas_penyusutan->getField("AKM_PENYUSUTAN_LALU"))?></td>
        	<td><?=numberToIna($kalkulas_penyusutan->getField("NILAI_PENYUSUTAN"))?></td>
        	<td><?=numberToIna($kalkulas_penyusutan->getField("AKM_PENYUSUTAN"))?></td>
            <td><?=numberToIna($kalkulas_penyusutan->getField("NILAI_AKHIR"))?></td>
        </tr>
      <?
	  $no++;
	  }
	  ?>
	</table>
    
    </body>
</html>