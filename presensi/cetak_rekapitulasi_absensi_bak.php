<?
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-absensi/AbsensiRekap.php");

$reqId = httpFilterGet("reqId");
$reqPeriode = httpFilterGet("reqPeriode");

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=cetak_rekapitulasi_absensi.xls");

$absensi_rekap = new AbsensiRekap();
$absensi_rekap->selectByParamsRekapAbsensi(array("A.NRP" => $reqId),-1,-1, "", $reqPeriode, "");
$absensi_rekap->firstRow();

$day = maxHariPeriode($reqPeriode);
$reqTahun= substr($reqPeriode,2,4);
$reqBulan= substr($reqPeriode,0,2);

?>
<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
<style>
	body, table{
		font-size:13px;
		font-family:Arial, Helvetica, sans-serif;
	}
	thead, tbody, tfoot {
		border: 3px solid black;
	}
	table.myTable { 
		
		width:100%;
		border-collapse: collapse; 
	}
	table.myTable td, 
	table.myTable th { 
		border: 1px solid black;
		padding: 5px; 
	}
</style>
<table style="width:100%">
	<tr>
    	<th colspan="6"><strong><u>REKAPITULASI ABSEN</u></strong></th>
    </tr>
	<tr>
    	<th colspan="6"><strong>PT. PELINDO PROPERTI INDONESIA</strong></th>
    </tr>
    <tr>
    	<th colspan="6">Periode : <?=getSelectFormattedDate($reqBulan)?> <?=$reqTahun?></th>
    </tr>
</table>
<br/>
<br/>
Nama Pegawai : <?=$absensi_rekap->getField("NAMA")?>
<table class="myTable">
	<thead>
        <tr>
            <th rowspan="2" style="width:10%">Tanggal</th>
            <th rowspan="2" style="width:10%">Hari</th>
            <th colspan="2" style="width:20%">Jam Kerja</th>
            <th style="width:15%">Jumlah</th>
            <th rowspan="2" style="width:45%">Uraian</th>
        </tr>
        <tr>
            <th>Masuk</th>
            <th>Keluar</th>
            <th>Jam Kerja</th>
        </tr>
    </thead>
    <tbody>
    	<tr>
        	<td>&nbsp;</td>
        	<td>&nbsp;</td>
        	<td>&nbsp;</td>
        	<td>&nbsp;</td>
        	<td>&nbsp;</td>
        	<td>&nbsp;</td>
        </tr>
		<?
		$sum_time = 0;
        for($i=1; $i<=$day; $i++)
        {
			
			if($i <= 9)
				$tgl = '0'.$i;
			else 
				$tgl = $i;
				
			$hari = getNamaHari($tgl, $reqBulan, $reqTahun);
        ?>
        <tr>
            <td style="text-align:center"><?=$tgl.'/'.$reqBulan.'/'.$reqTahun?></td>
            <td style="text-align:center"><?=$hari?></td>
            <td style="text-align:center"><?=$absensi_rekap->getField("IN_".$i)?></td>
            <td style="text-align:center"><?=$absensi_rekap->getField("OUT_".$i)?></td>
            <td style="text-align:center"><?=$absensi_rekap->getField("JJ_".$i)?></td>
            <td style="text-align:center">&nbsp;</td>
        </tr>
        <?	
			list($hour,$minute,$second) = explode(':', $absensi_rekap->getField("JJ_".$i));
			$seconds += $hour*3600;
			$seconds += $minute*60;
			$seconds += $second;
        }
			$hours = floor($seconds/3600);
			$seconds -= $hours*3600;
			$minutes  = floor($seconds/60);
			$seconds -= $minutes*60;
        ?>
        <tr>
        	<td>&nbsp;</td>
        	<td>&nbsp;</td>
        	<td>&nbsp;</td>
        	<td>&nbsp;</td>
        	<td>&nbsp;</td>
        	<td>&nbsp;</td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4" style="text-align:center"><strong>TOTAL :</strong></td>
            <td style="text-align:center"><strong><?=$hours.':'.$minutes?></strong></td>
            <td></td>
        </tr>
    </tfoot>
</table>
<br>
<br>
<table align="right" style="padding-right:200px">
    <tr>
    	<th width="55%">&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>Surabaya, <?=date("d-m-Y")?></th>
    </tr>
    <tr>
    	<th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
    	<th><strong>HR & GA SECTION HEAD</strong></th>
    </tr>
    <tr>
    	<th>&nbsp;</th>
    	<th><br><br><br><br><br></th>
    </tr>
    <tr>
    	<th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
    	<th><strong><u>ADI SETIAWAN</u></strong></th>
    </tr>
</table>
</body>
</html>