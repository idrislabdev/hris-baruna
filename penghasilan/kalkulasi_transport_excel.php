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
include_once("../WEB-INF/classes/base-simpeg/Departemen.php");

$kalkulasi_transport = new KalkulasiTransport();
$departemen = new Departemen();

$reqPeriode = httpFilterGet("reqPeriode");
$reqExcel = httpFilterGet("reqExcel");
$reqDepartemen = httpFilterGet("reqDepartemen");
$reqJenisPegawaiId = httpFilterGet("reqJenisPegawaiId");

// if($reqExcel == "1")
// {
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=kalkulasi_transport_karyawan.xls");
// }

$gaji_awal_bulan = new GajiAwalBulan();
$gaji = new Gaji();

$statement_privacy .= " AND A.PERIODE = '".$reqPeriode."' ";

 
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


$kalkulasi_transport->selectByParams(array(), -1, -1, $statement.$statement_privacy, "ORDER BY PEGAWAI_ID ASC");

// echo($kalkulasi_transport->query);exit();

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
    <p align="left"><font size="4"><b> DAFTAR KALKULASI TRANSPORT PEGAWAI</b></font>
    <p align="left"><font size="4"><b> UNIT KERJA : <?=strtoupper($reqNamaDepartemen)?></b></font>
    </p>
    <table class="area-data-slip" border="1">
      <thead>
      <tr>
           <th>No.</th>
           <th>NRP</th>
           <th>NAMA</th>
           <th>JABATAN</th>
           <th>JUMLAH HADIR</th>
           <th>TARIF</th>
           <th>TOTAL</th>
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
                <td><?=$kalkulasi_transport->getField("NRP")?></td>
                <td><?=$kalkulasi_transport->getField("NAMA_PEGAWAI")?></td>
                <td><?=$kalkulasi_transport->getField("JABATAN")?></td>
                <td><?=$kalkulasi_transport->getField("JUMLAH_HADIR")?></td>
                <td><?=numberToIna($kalkulasi_transport->getField("TARIF"))?></td>
                <td><?=numberToIna($kalkulasi_transport->getField("TOTAL"))?></td>
                <!-- <td><?=numberToIna($kalkulasi_transport)?></td> -->
            <?
            $no++;
        }
        ?>
      </tbody>
	</table>
</table>
    </body>
</html>