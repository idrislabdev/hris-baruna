<?
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-absensi/AbsensiRekap.php");

$reqId = httpFilterGet("reqId");
$reqPeriode = httpFilterGet("reqPeriode");

$absensi_rekap = new AbsensiRekap();
$absensi_rekap->selectByParamsRekapAbsensi(array("A.NRP" => $reqId),-1,-1, "", $reqPeriode, "");
$absensi_rekap->firstRow();

$day = maxHariPeriode($reqPeriode);
$reqTahun= substr($reqPeriode,2,4);
$reqBulan= substr($reqPeriode,0,2);

?>
<?php
//start report
$html = "
<table style='width:100%'>
	<tr><th><strong><u>REKAPITULASI ABSEN</u></strong></th></tr>
	<tr><th><strong>PT. PELINDO PROPERTI INDONESIA</strong></th></tr>
    <tr><th>Periode : ".getSelectFormattedDate($reqBulan)." ".$reqTahun."</th></tr>
</table>
<br/>
Nama Pegawai : ".$absensi_rekap->getField("NAMA")."
<table class='myTable'>
	<thead>
        <tr>
            <th rowspan='2' style='width:15%'>Tanggal</th>
            <th rowspan='2' style='width:20%'>Hari</th>
            <th colspan='2' style='width:30%'>Jam Kerja</th>
            <th style='width:20%'>Jumlah</th>
            <th rowspan='2' style='width:30%'>Uraian</th>
        </tr>
        <tr>
            <th style='width:10%'>Masuk</th>
            <th style='width:10%'>Keluar</th>
            <th>Jam Kerja</th>
        </tr>
    </thead>
    <tbody> "
?>
<?
		$sum_time = 0;
        for($i=1; $i<=$day; $i++)
        {
			
			if($i <= 9)
				$tgl = '0'.$i;
			else 
				$tgl = $i;
				
			$hari = getNamaHari($tgl, $reqBulan, $reqTahun)
?>
<?
$html .="
        <tr>
            <td style='text-align:center'>".$tgl.'/'.$reqBulan.'/'.$reqTahun."</td>
            <td style='text-align:center'>".$hari."</td>
            <td style='text-align:center'>".$absensi_rekap->getField('IN_'.$i)."</td>
            <td style='text-align:center'>".$absensi_rekap->getField('OUT_'.$i)."</td>
            <td style='text-align:center'>".$absensi_rekap->getField('JJ_'.$i)."</td>
            <td style='text-align:center'>&nbsp;</td>
        </tr>"
?>
    <?
			list($hour,$minute,$second) = explode(':', $absensi_rekap->getField('JJ_'.$i));
			$seconds += $hour*3600;
			$seconds += $minute*60;
			$seconds += $second;
        }
			$hours = floor($seconds/3600);
			$seconds -= $hours*3600;
			$minutes  = floor($seconds/60);
			$seconds -= $minutes*60;
        ?>
<?
$html .="
    </tbody>
    <tfoot>
        <tr>
            <td colspan='4' style='text-align:center'><strong>TOTAL :</strong></td>
            <td style='text-align:center'><strong> ".$hours.':'.$minutes." </strong></td>
            <td></td>
        </tr>
    </tfoot>
</table>
<br>
<table align='right' style='padding-right:60px'>
    <tr>
        <th>Surabaya, ".date('d-m-Y')."</th>
    </tr>
    <tr>
    	<th><strong>HR & GA SECTION HEAD</strong></th>
    </tr>
    <tr>
    	<th><br><br><br><br><br></th>
    </tr>
    <tr>
    	<th><strong><u>ADI SETIAWAN</u></strong></th>
    </tr>
</table> 
"
?>
<?
include_once("../WEB-INF/lib/MPDF60/mpdf.php");

$mpdf = new mPDF('c','A4',0,'',12,15,11,11,9,9, 'L');
//$mpdf=new mPDF('c','A4'); 

$mpdf->SetDisplayMode('fullpage');

$mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a list

// LOAD a stylesheet
$stylesheet = file_get_contents('../WEB-INF/css/rekapitulasi-absen-pdf.css');
$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text

$mpdf->WriteHTML($html,2);

$mpdf->Output('form_cuti_tahunan_cuti_besar_pdf.pdf','I');
exit;
//==============================================================
//==============================================================
//==============================================================
?>