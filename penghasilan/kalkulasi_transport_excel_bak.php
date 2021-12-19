<?
ini_set('max_execution_time', 500); //300 seconds = 5 minutes
ini_set('memory_limit','2048M');

include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/recordcoloring.func.php");
include_once("../WEB-INF/classes/base-gaji/GajiAwalBulan.php");
include_once("../WEB-INF/classes/base-gaji/Gaji.php");
include_once("../WEB-INF/classes/base-gaji/KalkulasiTransport.php");

$kalkulasi_transport = new KalkulasiTransport();

$reqPeriode = httpFilterGet("reqPeriode");
$reqExcel = httpFilterGet("reqExcel");
$reqDepartemen = httpFilterGet("reqDepartemen");
$reqJenisPegawaiId = httpFilterGet("reqJenisPegawaiId");
// echo $reqJenisPegawaiId;exit();


//echo " report pas gate";exit;

// if($reqExcel == "1")
// {
// header("Content-type: application/vnd-ms-excel");
// header("Content-Disposition: attachment; filename=kalkulasi_transport_karyawan.xls");
// }

$gaji_awal_bulan = new GajiAwalBulan();
$gaji = new Gaji();

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

// $i = 0;   
// $arrKolom[$i]= "NRP"; $arrField[$i]= "NRP"; $arrPrefix[$i]= "NRP";
// $i++;
// $arrKolom[$i] = "Nama"; $arrField[$i]= "NAMA_PEGAWAI"; $arrPrefix[$i]= "NAMA_PEGAWAI";
// $i++;
// $arrKolom[$i] = "Jabatan"; $arrField[$i]= "JABATAN"; $arrPrefix[$i]= "JABATAN";
// $i++;
// $arrKolom[$i] = "Jumlah Hadir"; $arrField[$i]= "JUMLAH_HADIR"; $arrPrefix[$i]= "JUMLAH_HADIR";
// $i++;
// $arrKolom[$i] = "Tarif"; $arrField[$i]= "TARIF"; $arrPrefix[$i]= "TARIF";
// $i++;

// for($j=0;$j<count($json_item_gaji->{"ITEM_GAJI"});$j++)
// {
//     $arrKolom[$i] = $json_item_gaji->{"NAMA"}{$j};   
//     $arrField[$i] = "GAJI_".$json_item_gaji->{"ITEM_GAJI"}{$j};   
//     $arrPrefix[$i] = $json_item_gaji->{"ITEM_GAJI"}{$j};   
//     $i++;
// }
// for($j=0;$j<count($json_item_potongan->{"ITEM_POTONGAN"});$j++)
// {
//   $arrKolom[$i] = $json_item_potongan->{"NAMA"}{$j};
//   $arrField[$i] = "POTO_".$json_item_potongan->{"ITEM_POTONGAN"}{$j};   
//   $arrPrefix[$i] = "POTONGAN_".$json_item_potongan->{"ITEM_POTONGAN"}{$j};
//   $i++;   
// }

// $arrKolom[$i] = "Hutang"; $arrField[$i]= "JUMLAH_POTONGAN_LAIN"; $arrPrefix[$i]= "JUMLAH_POTONGAN_LAIN";
// $i++;
// $arrKolom[$i] = "Jml. Potongan"; $arrField[$i]= "JUMLAH_POTONGAN"; $arrPrefix[$i]= "JUMLAH_POTONGAN";
// $i++;
// $arrKolom[$i] = "Jml. Dibayar"; $arrField[$i]= "JUMLAH_DIBAYAR"; $arrPrefix[$i]= "JUMLAH_DIBAYAR";
// $i++;		

 
if(substr($reqDepartemen, 0, 3) == "CAB")
  $statement = " AND EXISTS(SELECT 1 FROM PPI_SIMPEG.DEPARTEMEN X WHERE B.DEPARTEMEN_ID = X.DEPARTEMEN_ID AND X.CABANG_ID = '".str_replace("CAB","",$reqDepartemen)."') ";
else
  $statement = " AND B.DEPARTEMEN_ID LIKE '".$reqDepartemen."%'";

if($reqJenisPegawaiId == "")
{}
else
{
  $statement .= " AND B.JENIS_PEGAWAI_ID IN (".$reqJenisPegawaiId.") ";
}

// echo $statement;exit();


$kalkulasi_transport->selectByParams(array(), -1, -1, $statement, "ORDER BY PEGAWAI_ID ASC");
// echo($kalkulasi_transport->query);exit();
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
        
    <style>
  		@media print {
  			body{
  				*display:none;
  			}
  			body.laporan-kalkulasi-gaji table th{
  				padding:2px 2px;
  			}
  			body.laporan-kalkulasi-gaji table td{
  				padding:2px 2px;
  			}
			
  			table{
  				border-collapse:collapse;
  				width:100%;
  				*border-collapse: unset;
  				*border-top:1px solid red !important;
  			}
  			
  			table tr td{
  				page-break-inside:avoid;
  				*page-break-before:auto;
  				*border-top:1px solid red !important;
  				
  			}
  			table.area-data-slip tr td{
  				border:1px solid #000 !important;
  			}
			
        pre, blockquote {
          page-break-inside: avoid;
        }
  		}

  		@page  
  		{ 
  			size: auto;   /* auto is the initial value */ 
  		
  			/* this affects the margin in the printer settings */ 
  			margin: 1mm 2mm 1mm 2mm;  
  		} 
		
		table.area-data-slip{
			border-collapse:collapse;
			width:100%;
			*border:1px solid cyan !important;
		}
		table.area-data-slip tr th,
		table.area-data-slip tr td{
			*border:1px solid red !important;
		}
		table.area-data-slip tr{
			page-break-inside:avoid; 
			*page-break-after:always;
		}
		
		/****/
		table.ttd{
			page-break-after: always;
		}
		
		

    </style>
        
	</head>
    
	<body oncontextmenu="return false;" class="laporan-kalkulasi-gaji">
    <p align="left"><font size="4"><b> DAFTAR KALKULASI TRANSPORT PEGAWAI YBBS DAN PEGAWAI DPK</b></font>
    <p align="left"><font size="4"><b> UNIT KERJA : </b></font>
    </p>
    <table class="area-data-slip" border="1">
      <thead>
      <tr>
           <th style="border: 1px solid #000";>No.</th>
           <th style="border: 1px solid #000";>NRP</th>
           <th style="border: 1px solid #000";>NAMA</th>
           <th style="border: 1px solid #000";>JABATAN</th>
           <th style="border: 1px solid #000";>JUMLAH HADIR</th>
           <th style="border: 1px solid #000";>TARIF</th>
         </tr>
      </thead>
      <tbody>
        <?
        $no=1;
        // echo $kalkulasi_transport->query;exit();
        while ($kalkulasi_transport->nextRow()) {
          // $kalkulasi_transport = 0;
          ?> 
              <tr>
                <td><?=$no?></td>
                <td style="border: 1px solid #000"><?=$kalkulasi_transport->getField("NRP")?></td>
                <td style="border: 1px solid #000"><?=$kalkulasi_transport->getField("NAMA_PEGAWAI")?></td>
                <td style="border: 1px solid #000"><?=$kalkulasi_transport->getField("JABATAN")?></td>
                <td style="border: 1px solid #000"><?=$kalkulasi_transport->getField("JUMLAH_HADIR")?></td>
                <td style="border: 1px solid #000"><?=$kalkulasi_transport->getField("TARIF")?></td>
                <!-- <td style="border: 1px solid #000"><?=numberToIna($kalkulasi_transport)?></td> -->
            <?
            $no++;
        }
        ?>
        <tr>
<!--           <?
          for($i=-1;$i<count($arrKolom);$i++)
          {
            ?> 
            <td>
              <?=$test[$i]?>
            </td>
            <?
           }
            ?> -->

            
          <!--<td style="border: 1px solid #000"><?=numberToIna($sum)?>></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td style="border: 1px solid #000"><?=numberToIna($keseluruhan_gaji)?></td>
          <td></td>
          <td></td>
          <td style="border: 1px solid #000"><?=numberToIna($keseluruhan_potongan)?></td>
         <td style="border: 1px solid #000"><?=numberToIna($total_bayar_keseluruhan)?></td> -->
        </tr> 
      </tbody>
	</table>
      <p align="left"> <b><i>Terbilang :</p></i></b>
      <p align="right"> Surabaya, 26 November 2018</p>
  <table class="area-data-slip" width="100%">
    <tr>
      <td style="text-align: center"></td>
      <td style="text-align: center"></td>
      <td style="text-align: center"></td>
      <td style="text-align: center">Menyetujui</td>
      <td style="text-align: center"></td>
      <td style="text-align: center"></td>
      <td style="text-align: center"></td>
      <td style="text-align: center"></td>
      <td style="text-align: center"></td>
      <td style="text-align: center"></td>
      <td style="text-align: center">Mengetahui</td>
    </tr>
    <tr>
      <td style="text-align: center"></td>
      <td style="text-align: center"></td>
      <td style="text-align: center"></td>
      <td style="text-align: center">Ketua Pengurus YBBS </td>
      <td style="text-align: center"></td>
      <td style="text-align: center"></td>
      <td style="text-align: center"></td>
      <td style="text-align: center"></td>
      <td style="text-align: center"></td>
      <td style="text-align: center"></td>
      <td style="text-align: center">Bendahara Pengurus YBBS </td>
      <td style="text-align: center"></td>
      <td style="text-align: center"></td>
      <td style="text-align: center"></td>
      <td style="text-align: center"></td>
      <td style="text-align: center"></td>
      <td style="text-align: center"></td>
      <td style="text-align: center"></td>
      <td style="text-align: center"></td>
      <td style="text-align: center"></td>
      <td style="text-align: center">Pembuat Daftar Gaji,</td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td style="text-align: center"></td>
      <td style="text-align: center"></td>
      <td style="text-align: center"></td>
      <td style="text-align: center"><b>ANDITO SUTARTO</b></td>
      <td style="text-align: center"></td>
      <td style="text-align: center"></td>
      <td style="text-align: center"></td>
      <td style="text-align: center"></td>
      <td style="text-align: center"></td>
      <td style="text-align: center"></td>
      <td style="text-align: center"><b>Y. TEGUH PRATIKNO</b></td>      
      <td style="text-align: center"></td>
      <td style="text-align: center"></td>
      <td style="text-align: center"></td>
      <td style="text-align: center"></td>
      <td style="text-align: center"></td>
      <td style="text-align: center"></td>
      <td style="text-align: center"></td>
      <td style="text-align: center"></td>
      <td style="text-align: center"></td>
      <td style="text-align: center"><b>ARIFIN</b></td>
    </tr>
</table>
    </body>
</html>