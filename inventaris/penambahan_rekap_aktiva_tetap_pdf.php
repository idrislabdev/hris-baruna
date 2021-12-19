<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/KalkulasiPenyusutan.php");

$kalkulasi_penyusutan = new KalkulasiPenyusutan();

$reqPeriode = httpFilterGet("reqPeriode");
$reqLokasi = httpFilterGet("reqLokasi");


if($reqLokasi == "" || $reqLokasi == 0)
{}
else
	$statement = " AND A.LOKASI_ID LIKE '".$reqLokasi."%'";

$kalkulasi_penyusutan->selectByParams(array());

?>
<?php
//start report
$html = "
<div style='margin-top:18px;' id='header'>
	<p style='text-decoration:underline; text-align:center; width:950px;'><strong>DAFTAR PENAMBAHAN REKAP AKTIVA TETAP</strong></p>
</div>
<div id='detil'>
	<table style='margin-bottom:30px;'>
		<tr>
			<td align='justify'>NAMA AKTIVA</td>
			<td align='justify'>SISA UMUR</td>
			<td align='justify'>HARGA PEROLEHAN</td>
			<td align='justify'>NILAI PENYUSUTAN</td>
			<td align='justify'>AKM PENYUSUTAN</td>
			<td align='justify'>NILAI BUKU</td>
		</tr>
	"
	?>
	<?
	$i = 1;
	// $inventaris = "";
	while($kalkulasi_penyusutan->nextRow())
	{
	?> 
	<?
	  $html.="        
		<tr>
			<td align='justify' style='width:100px'>".$kalkulasi_penyusutan->getField("NAMA")."</td>
			<td align='justify' style='width:80px'>".$kalkulasi_penyusutan->getField("SISA")."</td>
			<td align='justify' style='width:120px'>".$kalkulasi_penyusutan->getField("NILAI_PEROLEHAN")."</td>
			<td align='justify' style='width:140px'>".$kalkulasi_penyusutan->getField("NILAI_PENYUSUTAN")."</td>
			<td align='justify' style='width:120px'>".$kalkulasi_penyusutan->getField("AKM_PENYUSUTAN")."</td>
			<td align='justify' style='width:80px'>".$kalkulasi_penyusutan->getField("NILAI_AKHIR")."</td>
		</tr>
		"
	?>
	<?	
	}
	?>
	<?
	$html.="
	</table>
</div> <!-- END DETIL -->
";
?>
<?

//==============================================================
//==============================================================
//==============================================================
include("../WEB-INF/lib/MPDF60/mpdf.php");

$mpdf=new mPDF('c','A4'); 

$mpdf->SetDisplayMode('fullpage');

$mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a list

// LOAD a stylesheet
$stylesheet = file_get_contents('../WEB-INF/css/rekap_pelaporan.css');
$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text

$mpdf->WriteHTML($html,2);

$mpdf->Output('penambahan_rekap_inventaris_ruangan.pdf','I');
exit;
//==============================================================
//==============================================================
//==============================================================


?>