<?php
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/Validate.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KpttNotaSpp.php");

$kptt_nota_spp = new KpttNotaSpp();


$reqTanggalAwal = httpFilterGet("reqTanggalAwal");
$reqTanggalAkhir = httpFilterGet("reqTanggalAkhir");
$reqDepartemen = httpFilterGet("reqDepartemen");


ini_set("memory_limit","500M");
ini_set('max_execution_time', 520);

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=rekap_pembayaran_spp.xls");

$aColumns = array("NO_NOTA", "NO_REF2", "TGL_TRANS", "KD_KUSTO", "MPLG_NAMA", "DEPARTEMEN_KELAS", "TANGGAL_TAGIHAN", "JML_VAL_TRANS");
$aColumnsAlias = array("NO INVOICE", "TRANSAKSI","TGL. TRANSAKSI", "NIS", "SISWA", "SEKOLAH", "PERIODE", "PEMBAYARAN");

$sOrder = " ORDER BY A.TGL_TRANS, A.KD_KUSTO ASC";
$statement = " AND A.TGL_TRANS BETWEEN TO_DATE('".$reqTanggalAwal."', 'DD-MM-YYYY') AND TO_DATE('".$reqTanggalAkhir."', 'DD-MM-YYYY') ";


if(!empty($reqDepartemen))
    $statement .= " AND AA.DEPARTEMEN_ID = '$reqDepartemen'  ";


$kptt_nota_spp->selectByParamsReport(array(), -1, -1, $statement, $sOrder);        


if(!empty($reqDepartemen))
{
    $kptt_nota_spp_dep = new KpttNotaSpp();
    $kptt_nota_spp_dep->selectByParamsDepartemen(array("B.DEPARTEMEN_ID" => $reqDepartemen));
    $kptt_nota_spp_dep->firstRow();
    $reqDepartemen = $kptt_nota_spp_dep->getField("NAMA");
    $reqHeader = $reqDepartemen."<br>";
}


if($reqTanggalAwal == $reqTanggalAkhir)
    $reqHeader .= "TANGGAL ".getFormattedDate($reqTanggalAwal);
else
    $reqHeader .= strtoupper(getFormattedDate(dateToPage($reqTanggalAwal))). " S.D ".strtoupper(getFormattedDate(dateToPage($reqTanggalAkhir)));    
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
    
    <div class="area-keterangan-slip">
    	<div align="center"><b>DAFTAR REKAPITULASI PEMBAYARAN<br>
         <?=$reqHeader?></b></div>
    </div> 
    
    <table class="area-data-slip" border="1">
        <tr>       
        <?
            for ( $i=0 ; $i<count($aColumnsAlias) ; $i++ )
            {
                    echo "<th>".($aColumnsAlias[$i])."</th>";
            }
        ?>  
        </tr>
      <?
			$no= 1;
			$arrData = array();
            $jumlah = 0;
			while($kptt_nota_spp->nextRow())
			{
				?>
                <tr>
                <?
				$row = array();
				for ( $i=0 ; $i<count($aColumns) ; $i++ )
				{
					if($aColumns[$i] == "JML_VAL_TRANS")
                    {
                        $jumlah += $kptt_nota_spp->getField($aColumns[$i]);
                        echo "<td align=\"right\">".numberToIna($kptt_nota_spp->getField($aColumns[$i]))."</td>";           
                    }
                    elseif($aColumns[$i] == "TGL_TRANS")
                    {
                        echo "<td align=\"left\">".dateToPage($kptt_nota_spp->getField($aColumns[$i]))."</td>";           
                    }
                    elseif($aColumns[$i] == "TANGGAL_TAGIHAN")
                    {
                        $arrTagihan = explode(" ", getFormattedDate($kptt_nota_spp->getField($aColumns[$i])));
                        $periodeTagihan = $arrTagihan[1]." ".$arrTagihan[2];
                        echo "<td align=\"center\">".$periodeTagihan."</td>";
                    }
					else
                        echo "<td>".$kptt_nota_spp->getField($aColumns[$i])."</td>";
				}
				?>
                </tr>
                <?
			}
	  ?>
      <tr>
          <td colspan="7"></td>
          <td align="right"><?=numberToIna($jumlah)?></td>
      </tr>
	</table>
    

    <table style="width: 100%">
        <tr>
            <td align="center" width="50%">LO</td>
            <td align="center" width="50%">Staff Penerima Yayasan</td>
        </tr>
        <tr>
            <td align="center" width="50%"><br><br><br><br></td>
            <td><br><br><br><br></td>
        </tr>
        <tr>
            <td align="center" width="50%">_______________________</td>
            <td align="center" width="50%">_______________________</td>
        </tr>
    </table>

    </body>
</html>