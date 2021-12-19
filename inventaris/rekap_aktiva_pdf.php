<?
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/InventarisRuangan.php");
include_once("../WEB-INF/classes/base-inventaris/Lokasi.php");

$reqLokasi =  httpFilterGet("reqLokasi");  
$lokasi 	= new Lokasi();

$inventaris_ruangan = new InventarisRuangan();

$inventaris_ruangan->selectByParams(array("A.LOKASI_ID" => $reqLokasi));
 
$lokasi->selectByParams(array("LOKASI_ID" => $reqLokasi)); 
$lokasi->firstRow();
$reqGM =  $lokasi->getField("GM");
$reqManager =  $lokasi->getField("MANAGER");
$reqAsman =  strtoupper($lokasi->getField("ASMAN"));
$reqJabatanManager =  strtoupper($lokasi->getField("JABATAN_MANAGER"));
$reqJabatanAsman =  strtoupper($lokasi->getField("JABATAN_ASMAN"));
?>
<?php
//start report
$html = "
<div style='margin-top:18px;' id='header'>
	<p style='text-decoration:underline; text-align:center; width:950px;'><strong>DAFTAR INVENTARIS RUANGAN</strong></p>
</div>
<div id='kop'>
	<table border='0' >
	  <tr>
		<td>Unit Kerja </td>
		<td>:</td>
		<td>CABANG KOTABARU</td> 
	  </tr>
	  <tr> 	
		<td>Lokasi </td>
		<td>:</td>
		<td>".$lokasi->getField("LOKASI_INDUK")."</td>
	  </tr>
	  <tr> 	
		<td>Ruangan </td>
		<td>:</td>
		<td>".$lokasi->getField("NAMA")."</td>
	  </tr>
	</table>
</div>
<br />
<div id='detil'>
	<table style='margin-bottom:30px;'>
		<tr>
			<td rowspan='2' align='center'>NO</td>
			<td colspan='3' align='center'>BARANG INVENTARIS </td>
			<td rowspan='2' align='center'>KONDISI <br /> (%)</td>
			<td rowspan='2' align='center'>KETERANGAN </td>
		</tr>
		<tr>
			<td align='center'>Jenis Barang </td>
			<td align='center'>Merk / Type </td>
			<td align='center'>Nomor </td>  
		</tr>
	"
	?>
	<?
	$i = 1;
		while($inventaris_ruangan->nextRow())
		{
	?>
	<?
	  $html.="        
		<tr>
			<td align='center'>".$i."</td>
			<td align='justify' style='padding-left:10px'>".strtoupper($inventaris_ruangan->getField("JENIS_INVENTARIS"))."</td>
			<td align='justify' style='padding-left:10px'>".strtoupper($inventaris_ruangan->getField("NAMA"))."</td>
			<td align='center'>".$inventaris_ruangan->getField("NOMOR")."</td>
			<td align='center'>".$inventaris_ruangan->getField("KONDISI")."</td>
			<td align='center'></td>
		</tr>
		"
	?>
	<?		
		$i++;
		}
	?>
	<?
	$html.="
	</table>
</div> <!-- END DETIL -->
"
?>
<?
$html.=
"
<div id='footer'>
	<table>
	  <tr>  
	"
	?>
	<?
		if($reqAsman <> "" && $reqManager <> "")
		{
	?>
	<?
	$html .= "
		<td align='center'>Mengetahui,</td>
		<td align='center'>Mengetahui,</td>
		<td align='center'>Surabaya, &nbsp;&nbsp;&nbsp;&nbsp;".getNamePeriode(date("mY"))."</td>
	"
	?> 
	<?
		}
		else
		{
	?>
	<?
		$html.="
		<td align='center'>Mengetahui,</td>
		<td align='center'>Kotabaru, &nbsp;&nbsp;&nbsp;&nbsp;".getNamePeriode(date("mY"))."</td>
		"
	?>
	<?
		}
	?>
	<?    
	  $html.="
	  </tr> 
	  <tr>
	  "
	?>
	<?
	  if($reqGM <> "")
	  {
	?>
	<?
		$html .=
		"
		<td align='center'>GENERAL MANAGER</td> 
		"
	?>
	<?
	  }
	?>
	<?
	  if($reqManager <> "")
	  {
	?> 
	<? 
		$html .=
		"
		<td align='center'>".$reqJabatanManager."</td>
		"
	?>
	<?
	  }
	?>
	<?
	  if($reqAsman <> "")
	  {
	?>   
	<?
	  $html .="
		<td align='center'>".$reqJabatanAsman."</td>
	  </tr> "
	?>
	<?
	  }
	?>
	
	<?
	  for($i=1;$i<=5;$i++)
	  {
	?>
	<?
	  $html .=
	  "
	  <tr> 
		<td colspan='3'>&nbsp;</td> 
	  </tr>
	  "
	?>
	<?
	  }
	?>
	<?
		$html .=
		"
		<tr>
		"
	?>
	<?
	  if($reqGM <> "")
	  {
	?>   
	<? 
		$html .= 
		"
		<td style='text-decoration:underline;' align='center'>".$reqGM."</td>  
		"
	?>
	<?
	  }
	?>
	<?
	  if($reqManager <> "")
	  {
	?>   
	<?
		$html .=
		"  
		<td style='text-decoration:underline;' align='center'>".$reqManager."</td>  
		"
	?>
	<?
	  }
	  if($reqAsman <> "")
	  {
	?>   
	<? 
		$html .= "    
		<td style='text-decoration:underline;' align='center'>".$reqAsman."</td>
		" 
	?>
	<?
	  }
	?>
	<?
		$html .=
	  "</tr>
	</table>
</div> <!-- END FOOTER -->
 ";//End Report


//==============================================================
//==============================================================
//==============================================================
include("../WEB-INF/lib/MPDF60/mpdf.php");

$mpdf=new mPDF('c','A4'); 

$mpdf->SetDisplayMode('fullpage');

$mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a list

// LOAD a stylesheet
$stylesheet = file_get_contents('../WEB-INF/css/cetak_inventaris.css');
$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text

$mpdf->WriteHTML($html,2);

$mpdf->Output('cetak_inventaris.pdf','I');
exit;
//==============================================================
//==============================================================
//==============================================================


?>