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
header("Content-Disposition: attachment; filename=rekap_aktiva_tetap.xls");

$date = strtotime(substr($reqPeriode, 2, 4)."-".(substr($reqPeriode, 0, 2))."-01");
$reqPeriodeLalu = date("mY", strtotime("-1 month", $date));

$reqTanggalAkhir = date("t", strtotime("0 month", $date));

$statement_privacy = " AND PERIODE = '".$reqPeriode."' ";
$sOrder = " ";

$aColumns = array("HEADER", "NILAI_KINI", "NILAI_LALU", "NILAI_PENAMBAHAN", "NILAI_PENGURANGAN", "AKM_PENYUSUTAN", "AKM_LALU", "AKM_PENAMBAHAN", "AKM_PENGURANGAN", "NILAI_AKHIR");
$aColumnsAlias = array("HEADER", "NILAI_KINI", "NILAI_LALU", "NILAI_PENAMBAHAN", "NILAI_PENGURANGAN", "AKM_PENYUSUTAN", "AKM_LALU", "AKM_PENAMBAHAN", "AKM_PENGURANGAN", "NILAI_AKHIR");

$kalkulas_penyusutan->selectByParamsRekapKelompokPeriode(array(), -1, -1, $statement_privacy, $sOrder);        

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
     -->
    
    <div class="area-keterangan-slip">
    	<div align="center"><b>DAFTAR REKAPITULASI AKTIVA TETAP<br>
         SALDO PER <?=$reqTanggalAkhir?> <?=strtoupper(getNamePeriode($reqPeriode))?></b></div>
    </div> 
    
    <table class="area-data-slip" border="1">
        <tr>  
            <th style="width:400px" rowspan="2">Kelompok</th>         
            <th width="50px" rowspan="2">Saldo Aktiva <?=getNamePeriode($reqPeriode)?></th>    
            <th width="50px" rowspan="2">Saldo Aktiva <?=getNamePeriode($reqPeriodeLalu)?></th>          
            <th width="50px" colspan="2">Mutasi Aktiva</th>     
            <th width="50px" rowspan="2">Saldo Akm. Penyusutan</th>               
            <th width="50px" rowspan="2">Saldo Akm. Penyusutan <?=getNamePeriode($reqPeriodeLalu)?></th>           
            <th width="50px" colspan="2">Mutasi Penyusutan</th>   
            <th width="50px" rowspan="2">Nilai Buku</th> 
        </tr>
        <tr>
        	<td>Penambahan</td>
        	<td>Pengurangan</td>
        	<td>Penambahan</td>
        	<td>Pengurangan</td>
        </tr>
      <?
	  $no= 1;
			while($kalkulas_penyusutan->nextRow())
			{
				?>
                <tr>
                <?
				$row = array();
				for ( $i=0 ; $i<count($aColumns) ; $i++ )
				{
					if($aColumns[$i] == "HEADER")
						echo "<td>".$kalkulas_penyusutan->getField($aColumns[$i])."</td>";
					else
						echo "<td>".numberToIna($kalkulas_penyusutan->getField($aColumns[$i]))."</td>";			
				}
				
				?>
                </tr>
                <?
			}
	  ?>
	</table>
    
    </body>
</html>