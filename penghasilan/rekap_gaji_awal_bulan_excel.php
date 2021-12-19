<?
ini_set('max_execution_time', 500); //300 seconds = 5 minutes
ini_set('memory_limit','2048M');

include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/recordcoloring.func.php");
include_once("../WEB-INF/classes/base-gaji/GajiAwalBulan.php");
include_once("../WEB-INF/classes/base-gaji/Gaji.php");
include_once("../WEB-INF/classes/base-simpeg/Departemen.php");

$reqPeriode = httpFilterGet("reqPeriode");
$reqExcel = httpFilterGet("reqExcel");
$reqDepartemen = httpFilterGet("reqDepartemen");
$reqJenisPegawaiId = httpFilterGet("reqJenisPegawaiId");
// echo $reqJenisPegawaiId;exit();


//echo " report pas gate";exit;

if($reqExcel == "1")
{
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=laporan_gaji_karyawan.xls");
}

$gaji_awal_bulan = new GajiAwalBulan();
$gaji = new Gaji();
$departemen = new Departemen();

$statement_privacy .= " AND A.PERIODE = '".$reqPeriode."' ";
		

$reqNama1 = httpFilterGet("reqNama1");
$reqJabatan1 = httpFilterGet("reqJabatan1");
$reqNama2 = httpFilterGet("reqNama2");
$reqJabatan2 = httpFilterGet("reqJabatan2");

//echo $reqJabatan1;exit;

$reqNama1 = str_replace("_"," ",$reqNama1);
$reqJabatan1 = str_replace("_"," ",$reqJabatan1);
$reqNama2 = str_replace("_"," ",$reqNama2);
$reqJabatan2 = str_replace("_"," ",$reqJabatan2);
if($reqJenisPegawaiId == '') $reqJenisPegawaiId = 1;

$json_item_gaji = json_decode($gaji->getItemGajiDiberikan($reqJenisPegawaiId, "AWAL_BULAN"));
$json_item_sumbangan = json_decode($gaji->getItemSumbanganDiberikan($reqJenisPegawaiId));
$json_item_potongan = json_decode($gaji->getItemPotonganDiberikan($reqJenisPegawaiId));
$json_item_tanggungan = json_decode($gaji->getItemTanggunganDiberikan($reqJenisPegawaiId));
$json_item_potongan_lain = json_decode($gaji->getItemPotonganLain());

$i = 0;   
$arrKolom[$i]= "NRP"; $arrField[$i]= "NRP"; $arrPrefix[$i]= "NRP";
$i++;
$arrKolom[$i] = "Nama"; $arrField[$i]= "NAMA"; $arrPrefix[$i]= "NAMA";
$i++;
$arrKolom[$i] = "Status Pegawai"; $arrField[$i]= "STATUS_CALPEG_DESC"; $arrPrefix[$i]= "STATUS_CALPEG_DESC";
$i++;
$arrKolom[$i] = "Jabatan"; $arrField[$i]= "JABATAN"; $arrPrefix[$i]= "JABATAN";
$i++;
$arrKolom[$i] = "Kelas Jabatan"; $arrField[$i]= "KELAS"; $arrPrefix[$i]= "KELAS";
$i++;
$arrKolom[$i] = "Tugas Mengajar"; $arrField[$i]= "TUGAS_MENGAJAR"; $arrPrefix[$i]= "TUGAS_MENGAJAR";
$i++;

for($j=0;$j<count($json_item_gaji->{"ITEM_GAJI"});$j++)
{
    $arrKolom[$i] = $json_item_gaji->{"NAMA"}{$j};   
    $arrField[$i] = "GAJI_".$json_item_gaji->{"ITEM_GAJI"}{$j};   
    $arrPrefix[$i] = $json_item_gaji->{"ITEM_GAJI"}{$j};   
    $i++;
}
for($j=0;$j<count($json_item_potongan->{"ITEM_POTONGAN"});$j++)
{
  $arrKolom[$i] = $json_item_potongan->{"NAMA"}{$j};
  $arrField[$i] = "POTO_".$json_item_potongan->{"ITEM_POTONGAN"}{$j};   
  $arrPrefix[$i] = "POTONGAN_".$json_item_potongan->{"ITEM_POTONGAN"}{$j};
  $i++;   
}

// $arrKolom[$i] = "Hutang"; $arrField[$i]= "JUMLAH_POTONGAN_LAIN"; $arrPrefix[$i]= "JUMLAH_POTONGAN_LAIN";
// $i++;
// $arrKolom[$i] = "Jml. Potongan"; $arrField[$i]= "JUMLAH_POTONGAN"; $arrPrefix[$i]= "JUMLAH_POTONGAN";
// $i++;
$arrKolom[$i] = "Jml. Dibayar"; $arrField[$i]= "JUMLAH_DIBAYAR"; $arrPrefix[$i]= "JUMLAH_DIBAYAR";
$i++;		

 
if(substr($reqDepartemen, 0, 3) == "CAB")
  $statement = " AND EXISTS(SELECT 1 FROM PPI_SIMPEG.DEPARTEMEN X WHERE A.DEPARTEMEN_ID = X.DEPARTEMEN_ID AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') ";
else
  $statement = " AND A.DEPARTEMEN_ID LIKE '".$reqDepartemen."%'";

if($reqJenisPegawaiId == "")
{}
else
{
  $statement .= " AND A.JENIS_PEGAWAI_ID IN (".$reqJenisPegawaiId.") ";
}

// echo $statement;exit();


$gaji_awal_bulan->selectByParamsRekap(array(), -1, -1, $statement_privacy.$statement, "ORDER BY PEGAWAI_ID ASC");
// echo($gaji_awal_bulan->query);exit();

$departemen->selectByParams(array("DEPARTEMEN_ID" => $reqDepartemen));

$reqNamaDepartemen = $departemen->getField("NAMA");

if($reqDepartemen == "")
  $reqNamaDepartemen = "Semua";
else
  $reqNamaDepartemen = $reqNamaDepartemen;

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
    <!--<link rel="stylesheet" type="text/css" href="css/gaya.css">-->
		<!-- <link rel="stylesheet" type="text/css" href="css/gaya-laporan.css"> -->       
	</head>
    
	<body oncontextmenu="return false;" class="laporan-kalkulasi-gaji">
    <p align="left"><font size="4"><b> DAFTAR PENGHASILAN PEGAWAI </b></font>
    <p align="left"><font size="4"><b> UNIT KERJA : <?=strtoupper($reqNamaDepartemen)?></b></font>
    </p>
    <table class="area-data-slip" border="1">
      <thead>
      <tr>
           <th style="border: 1px solid #000";>No.</th>
            <?
            for($i=0;$i<count($arrKolom);$i++)
            {
            ?>
                <th style="border: 1px solid #000"><?=$arrKolom[$i]?></th>
            <?
            }
            ?>
        </tr>
      </thead>
      <tbody>
        <?
        $no=1;
        while ($gaji_awal_bulan->nextRow()) {
          $total_gaji = 0;
          $total_potongan = 0;
          ?>
              <tr>
                <td><?=$no?></td>
          <?
            for($i=0;$i<count($arrKolom);$i++)
            {
              if(substr($arrField[$i],0,4) == "GAJI")
              {
                $column_gaji = str_replace("GAJI_", "", $arrField[$i]);
                if($column_gaji == "TOTAL_GAJI")
                {
                  $hasil_gaji = $total_gaji;
                  $total_all[$i] +=$hasil_gaji;
                ?>
                  <td style="border: 1px solid #000" style="text-align: right;"><?=numberToIna($hasil_gaji)?></td>
                <?
                }
                else
                {
                  $keseluruhan_gaji+=$total_gaji;
                  $total_all[$i] += $gaji_awal_bulan->getField($arrPrefix[$i]);
                  $total_gaji += $gaji_awal_bulan->getField($arrPrefix[$i]);
                  ?>
                    <td style="border: 1px solid #000" style="text-align: right;"><?=numberToIna($gaji_awal_bulan->getField($arrPrefix[$i]))?></td>
                  <?
                }
              }
              elseif(substr($arrField[$i],0,4) == "POTO")
              {
                $column_potongan = str_replace("POTO_", "", $arrField[$i]);
                if($column_potongan == "TOTAL_POTONGAN")
                {
                  $total_all[$i] +=$hasil_potongan;
                  $hasil_potongan = $total_potongan;
                ?>
                  <td style="border: 1px solid #000" style="text-align: right;"><?=numberToIna($hasil_potongan)?></td>
                <?
                }
                else
                {
                  $keseluruhan_potongan+=$total_potongan;
                  $total_all[$i] += $gaji_awal_bulan->getField($arrPrefix[$i]);
                  $total_potongan += $gaji_awal_bulan->getField($arrPrefix[$i]);
                  ?>
                    <td style="border: 1px solid #000" style="text-align: right;"><?=numberToIna($gaji_awal_bulan->getField($arrPrefix[$i]))?></td>
                  <?
                }
              }
              elseif($arrField[$i] == "JUMLAH_DIBAYAR")
              {
                $total_bayar_keseluruhan+=$total_bayar;
                $total_all[$i] += $total_bayar;
                $grand_total_dibayar += $total_bayar;
                $total_bayar=$total_gaji-$total_potongan;
              ?>
                <td style="border: 1px solid #000" style="text-align: right;"><?=numberToIna($total_bayar)?></td>
              <?
              }
              else
              {
            ?>
                <td style="border: 1px solid #000"><?=$gaji_awal_bulan->getField($arrPrefix[$i])?></td>
            <?
              }
            }
            ?>
              </tr>
            <?
            $no++;
        }
        ?>
        <tr>
          <?
          for($i=-1;$i<count($arrKolom);$i++)
          {
            ?> 
            <td style="text-align: right;">
              <?=numberToIna($total_all[$i])?>
            </td>
            <?
           }
            ?>
        </tr>
      </tbody>
	</table>
      <p align="left"> <b><i>Terbilang :<?=ucwords(kekata($grand_total_dibayar))?></p></i></b>
      <p align="right"> Surabaya, 26 November 2018</p>
  <table class="area-data-slip" border="0" style="border-color: white 1px !important;">
    <tbody>
      <tr>
        <td colspan="3">Menyetujui</td>
        <td colspan="4">&nbsp;</td>
        <td colspan="3">Mengetahui</td>
        <td colspan="7">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3">Ketua Pengurus YBBS </td>
        <td colspan="4">&nbsp;</td>
        <td colspan="3">Bendahara Pengurus YBBS </td>
        <td colspan="4">&nbsp;</td>
        <td colspan="3">Pembuat Daftar Gaji,</td>
      </tr>
      <tr>
        <td colspan="17">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="17">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="17">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3"><b>ANDITO SUTARTO </b></td>
        <td colspan="4">&nbsp;</td>
        <td colspan="3"><b>Y. TEGUH PRATIKNO </b></td>
        <td colspan="4">&nbsp;</td>
        <td colspan="3"><b>ARIFIN </b></td>
      </tr>
    </tbody>
  </table>
    </body>
</html>