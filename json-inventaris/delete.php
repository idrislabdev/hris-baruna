<?
//include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/functions/default.func.php");

$reqId = $_GET['id'];
$reqRowId = $_GET['reqRowId'];
$reqMode = $_GET['reqMode'];
$reqAlasan = httpFilterGet("reqAlasan");


/* LOGIN CHECK */
/*if ($userLogin->checkUserLogin()) 
{ 
	$userLogin->retrieveUserInfo();
}*/
if($reqMode == "inventaris")
{
	include_once("../WEB-INF/classes/base-inventaris/Inventaris.php");
	$inventaris	= new Inventaris();
	$inventaris->setField('INVENTARIS_ID', $reqId);
	if($inventaris->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$inventaris->getErrorMsg();
}
else if($reqMode == "jenis_penyusutan")
{
	include_once("../WEB-INF/classes/base-inventaris/JenisSusut.php");
	$jenis_susut	= new JenisSusut();
	$jenis_susut->setField('JENIS_SUSUT_ID', $reqId);
	if($jenis_susut->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$jenis_susut->getErrorMsg();
}
else if($reqMode == "kondisi_fisik")
{
	include_once("../WEB-INF/classes/base-inventaris/KondisiFisik.php");
	$kondisi_fisik	= new KondisiFisik();
	$kondisi_fisik->setField('KONDISI_FISIK_ID', $reqId);
	if($kondisi_fisik->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$kondisi_fisik->getErrorMsg();
}
else if($reqMode == "jenis_inventaris")
{
	include_once("../WEB-INF/classes/base-inventaris/JenisInventaris.php");
	$jenis_inventaris	= new JenisInventaris();
	$jenis_inventaris->setField('JENIS_INVENTARIS_ID', $reqId);
	if($jenis_inventaris->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$jenis_inventaris->getErrorMsg();
}
else if($reqMode == "inventaris_ruangan")
{
	include_once("../WEB-INF/classes/base-inventaris/InventarisRuangan.php");
	$inventaris_ruangan	= new InventarisRuangan();
	$inventaris_ruangan->setField('INVENTARIS_ID', $reqId);
	$inventaris_ruangan->setField('LOKASI_ID', $reqRowId);
	if($inventaris_ruangan->deleteLokasi())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$inventaris_ruangan->getErrorMsg();
}
else if($reqMode == "inventaris_ruangan_detil")
{
	include_once("../WEB-INF/classes/base-inventaris/InventarisRuangan.php");
	$inventaris_ruangan	= new InventarisRuangan();
	$inventaris_ruangan->setField('INVENTARIS_RUANGAN_ID', $reqId);
	$inventaris_ruangan->setField('ALASAN_HAPUS', $reqAlasan);	
	if($inventaris_ruangan->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$inventaris_ruangan->getErrorMsg();
}
else if($reqMode == "perbaikan")
{
	include_once("../WEB-INF/classes/base-inventaris/InventarisPerbaikan.php");
	$inventaris_perbaikan	= new InventarisPerbaikan();
	$inventaris_perbaikan->setField('INVENTARIS_PERBAIKAN_ID', $reqId);
	if($inventaris_perbaikan->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$inventaris_perbaikan->getErrorMsg();
}
else if($reqMode == "penyusutan")
{
	include_once("../WEB-INF/classes/base-inventaris/InventarisPenyusutan.php");
	$inventaris_penyusutan	= new InventarisPenyusutan();
	$inventaris_penyusutan->setField('INVENTARIS_PENYUSUTAN_ID', $reqId);
	if($inventaris_penyusutan->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$inventaris_penyusutan->getErrorMsg();
}
else if($reqMode == "invoice")
{
	include_once("../WEB-INF/classes/base-inventaris/Invoice.php");
	$invoice	= new Invoice();
	$invoice->setField('INVOICE_ID', $reqId);
	if($invoice->delete())
		$alertMsg .= "Data berhasil dihapus";
	else
		$alertMsg .= "Error ".$invoice->getErrorMsg();
}
echo $alertMsg;
?>
