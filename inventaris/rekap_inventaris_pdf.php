<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/InventarisRuangan.php");

$inventaris_ruangan = new InventarisRuangan();

$reqInventaris = httpFilterGet("reqInventaris");
if($reqInventaris == "")
	$statement = "";
else
	$statement = " AND A.INVENTARIS_ID = ".$reqInventaris;
	
$inventaris_ruangan->selectByParamsRekapInventaris(array(), -1, -1, $statement,  "ORDER BY B.NAMA ASC");

?>
<?php
//start report
$html = "
<div style='margin-top:18px;' id='header'>
	<p style='text-decoration:underline; text-align:center; width:950px;'><strong>DAFTAR REKAP INVENTARIS</strong></p>
</div>
<div id='detil'>
	<table style='margin-bottom:30px;'>
		<tr>
			<td align='center'>NOMOR</td>
			<td align='center'>BARCODE</td>
			<td align='center'>LOKASI</td>
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
		if($inventaris == $inventaris_ruangan->getField("INVENTARIS"))
		{}
		else
		{
    ?>
    <?
		$html.="        
		<tr>
			<td colspan='5' align='center' bgcolor='#CCCCCC'>".$inventaris_ruangan->getField("INVENTARIS")."</td>
		</tr>
		"
    ?>    	
    <?
		}
    ?>
	<?
	  $html.="        
		<tr>
			<td align='center' style='width:80px'>".$inventaris_ruangan->getField("NOMOR")."</td>
			<td align='center' style='width:80px'>"." ".$inventaris_ruangan->getField("BARCODE")."</td>
			<td align='justify' style='width:280px'>".strtoupper($inventaris_ruangan->getField("LOKASI"))."</td>
			<td align='center' style='width:80px'>".getNamePeriode($inventaris_ruangan->getField("PEROLEHAN_PERIODE"))."</td>
			<td align='center' style='width:70px'>".$inventaris_ruangan->getField("PEROLEHAN_HARGA")."</td>
		</tr>
		"
	?>
	<?	
		$inventaris = $inventaris_ruangan->getField("INVENTARIS");	
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

$mpdf->Output('rekap_inventaris.pdf','I');
exit;
//==============================================================
//==============================================================
//==============================================================


?>