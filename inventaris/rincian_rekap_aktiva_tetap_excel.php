<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");
include_once("../WEB-INF/classes/base-inventaris/KalkulasiPenyusutan.php");

$kalkulas_penyusutan = new KalkulasiPenyusutan();

$reqPeriode = httpFilterGet("reqPeriode");
$reqPeriodeLalu = httpFilterGet("reqPeriodeLalu");

$date = strtotime(substr($reqPeriode, 2, 4)."-".(substr($reqPeriode, 0, 2))."-01");
$reqTanggalAkhir = date("t", strtotime("0 month", $date));


ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

/*header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=rincian_aktiva_tetap_".$reqPeriodeLalu."_".$reqPeriode.".xls");*/

$statement_privacy = " AND PERIODE = '".$reqPeriode."'";

$kalkulas_penyusutan->selectByParamsRekapAktivaV2($reqPeriode, $reqPeriodeLalu, array(), -1, -1, $statement_privacy, " ORDER BY KODE_HEADER, NAMA_HEADER, KODE, LOKASI_ID ");        

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
    
    
    <div  class="area-data-slip">
         <div class="atas" align="left">Status : <?=$reqStatusPegawaiNama?></div>
        <div class="bawah" align="left">Cabang : <?=$reqDepartemenNama?> </div>
    </div>     -->
   <div class="area-keterangan-slip">
    	<div align="center"><b>RINCIAN REKAPITULASI AKTIVA TETAP<br>
         SALDO PER <?=$reqTanggalAkhir?> <?=strtoupper(getNamePeriode($reqPeriode))?></b></div>
    </div>
 
    <table class="area-data-slip" border="1">

    	<tr>
            <th style="width:50px">KODE</th>          
            <th width="150px">LOKASI</th>          
            <th width="150px">NAMA AKTIVA</th>          
            <th width="150px">SPESIFIKASI</th>            
            <th width="50px">TANGGAL PEROLEHAN</th>           
            <th width="50px">SISA UMUR</th>   
            <th width="50px">HARGA PEROLEHAN</th>   
            <th width="50px">AKM PENYUSUTAN <?=strtoupper(getNamePeriode($reqPeriodeLalu))?></th>   
            <th width="50px">PENYUSUTAN S.D <?=strtoupper(getNamePeriode($reqPeriode))?></th>   
            <th width="50px">SALDO AKM PENYUSUTAN</th>   
            <th width="50px">NILAI BUKU</th>   
        </tr>
      <?
	  $no= 1;
	  $header = "";
	  
	  $AKM_PENYUSUTAN_LALU = 0;
	  $NILAI_PENYUSUTAN	   = 0; 
	  $AKM_PENYUSUTAN  	   = 0;
	  $NILAI_AKHIR 		   = 0;
	  
	  while($kalkulas_penyusutan->nextRow())
	  {

	  	if($header == $kalkulas_penyusutan->getField("HEADER"))
	  	{}
		else
		{
			if($header == "")
			{
			?>
	      	<tr>
	      		<td colspan="11" align="center" bgcolor="#CCCCCC"><?=$kalkulas_penyusutan->getField("HEADER")?></td>
	      	</tr>
            <?	
			}
			else
			{
			?>
              <tr>
              <td colspan="7"></td>
              <td align="right"><?=numberToIna($AKM_PENYUSUTAN_LALU)?></td> 
              <td align="right"><?=numberToIna($NILAI_PENYUSUTAN)?></td>
              <td align="right"><?=numberToIna($AKM_PENYUSUTAN)?></td>
              <td align="right"><?=numberToIna($NILAI_AKHIR)?></td>
              </tr>
	      	<tr>
	      		<td colspan="11" align="center" bgcolor="#CCCCCC"><?=$kalkulas_penyusutan->getField("HEADER")?></td>
	      	</tr>
			<?
			}
			  $AKM_PENYUSUTAN_LALU = 0;
			  $NILAI_PENYUSUTAN	   = 0; 
			  $AKM_PENYUSUTAN  	   = 0;
			  $NILAI_AKHIR 		   = 0;
		}
		$header = $kalkulas_penyusutan->getField("HEADER");
		?>
      	<tr>
        	<td><?=$kalkulas_penyusutan->getField("KODE")?></td>
        	<td><?=$kalkulas_penyusutan->getField("LOKASI")?></td>
        	<td><?=$kalkulas_penyusutan->getField("NAMA")?></td>
        	<td><?=$kalkulas_penyusutan->getField("SPESIFIKASI")?></td>
        	<td><?=dateToPageCheck($kalkulas_penyusutan->getField("TANGGAL_PEROLEHAN"))?></td>
        	<td align="right"><?=numberToIna($kalkulas_penyusutan->getField("SISA_UMUR"))?></td>
        	<td align="right"><?=numberToIna($kalkulas_penyusutan->getField("NILAI_PEROLEHAN"))?></td>
        	<td align="right"><?=numberToIna($kalkulas_penyusutan->getField("AKM_PENYUSUTAN_LALU"))?></td> 
        	<td align="right"><?=numberToIna($kalkulas_penyusutan->getField("NILAI_PENYUSUTAN"))?></td>
        	<td align="right"><?=numberToIna($kalkulas_penyusutan->getField("AKM_PENYUSUTAN"))?></td>
            <td align="right"><?=numberToIna($kalkulas_penyusutan->getField("NILAI_AKHIR"))?></td>
        </tr>
      <?

	  	$AKM_PENYUSUTAN_LALU   += $kalkulas_penyusutan->getField("AKM_PENYUSUTAN_LALU");
	  	$NILAI_PENYUSUTAN	   += $kalkulas_penyusutan->getField("NILAI_PENYUSUTAN"); 
	  	$AKM_PENYUSUTAN  	   += $kalkulas_penyusutan->getField("AKM_PENYUSUTAN");
	  	$NILAI_AKHIR 		   += $kalkulas_penyusutan->getField("NILAI_AKHIR");	  
	  	$no++;
	  }
	  ?>
      <tr>
      <td colspan="7"></td>
      <td align="right"><?=numberToIna($AKM_PENYUSUTAN_LALU)?></td> 
      <td align="right"><?=numberToIna($NILAI_PENYUSUTAN)?></td>
      <td align="right"><?=numberToIna($AKM_PENYUSUTAN)?></td>
      <td align="right"><?=numberToIna($NILAI_AKHIR)?></td>
      </tr>
	</table>
    
    </body>
</html>