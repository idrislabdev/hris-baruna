<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/InventarisRuangan.php");

$inventaris_ruangan = new InventarisRuangan();

$reqPeriode = httpFilterGet("reqPeriode");
$reqLokasi = httpFilterGet("reqLokasi");


if($reqLokasi == "" || $reqLokasi == 0)
{}
else
	$statement = " AND A.LOKASI_ID LIKE '".$reqLokasi."%'";

$inventaris_ruangan->selectByParamsRekapInventarisRuangan(array(), -1, -1, $statement,  " ORDER BY A.LOKASI_ID ASC");

?>
<?php
//start report
$html = "
<div style='margin-top:18px;' id='header'>
	<p style='text-decoration:underline; text-align:center; width:950px;'><strong>DAFTAR REKAP INVENTARIS RUANGAN</strong></p>
</div>
<div id='detil'>
	<table style='margin-bottom:30px;'>
		<tr>
			<td align='center'>INVENTARIS</td>
			<td align='center'>SPESIFIKASI</td>
			<td align='center'>NOMOR</td>
			<td align='center'>BARCODE</td>
			<td align='center'>PEROLEHAN</td>
			<td align='center'>HARGA</td>
		</tr>
	"
	?>
	<?
	$i = 1;
	$inventaris = "";
	while($inventaris_ruangan->nextRow())
	{
	?>
    <?
		if($inventaris == $inventaris_ruangan->getField("LOKASI"))
		{}
		else
		{
    ?>
    <?
		$html.="        
		<tr>
			<td colspan='6' align='center' bgcolor='#CCCCCC'>".$inventaris_ruangan->getField("LOKASI")."</td>
		</tr>
		"
    ?>    	
    <?
		}
    ?>
	<?
	  $html.="        
		<tr>
			<td align='center' style='width:180px'>".$inventaris_ruangan->getField("INVENTARIS")."</td>
			<td align='center' style='width:180px'>".$inventaris_ruangan->getField("SPESIFIKASI")."</td>
			<td align='justify' style='width:80px'>".$inventaris_ruangan->getField("NOMOR")."</td>
			<td align='center' style='width:80px'>"." ".$inventaris_ruangan->getField("BARCODE")."</td>
			<td align='center' style='width:70px'>".getNamePeriode($inventaris_ruangan->getField("PEROLEHAN_PERIODE"))."</td>
			<td align='center' style='width:70px'>".$inventaris_ruangan->getField("PEROLEHAN_HARGA")."</td>
		</tr>
		"
	?>
	<?	
		$inventaris = $inventaris_ruangan->getField("LOKASI");	
		$i++;
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

$mpdf->Output('rekap_inventaris_ruangan.pdf','I');
exit;
//==============================================================
//==============================================================
//==============================================================


?>