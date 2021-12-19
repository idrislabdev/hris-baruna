<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/base-inventaris/InventarisPenyusutan.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");

$inventaris_penyusutan = new InventarisPenyusutan();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqJenisSusut= httpFilterPost("reqJenisSusut");
$reqTanggalSusut=httpFilterPost("reqTanggalSusut");
$reqKeterangan=httpFilterPost("reqKeterangan");
$reqNama=httpFilterPost("reqNama");

	
if($reqMode == "insert")
{
	$inventaris_penyusutan->setField("TANGGAL_SUSUT", dateToDBCheck($reqTanggalSusut));
	$inventaris_penyusutan->setField("KETERANGAN", $reqKeterangan);
	$inventaris_penyusutan->setField("JENIS_SUSUT_ID", $reqJenisSusut);
	$inventaris_penyusutan->setField("NAMA", $reqNama);
	$inventaris_penyusutan->setField("TANGGAL", "CURRENT_DATE");	
	
	$inventaris_penyusutan->setField("LAST_CREATE_USER", $userLogin->nama);
	$inventaris_penyusutan->setField("LAST_CREATE_DATE", "CURRENT_DATE");	
	
	if($inventaris_penyusutan->insert())
	{
		$id=$inventaris_penyusutan->id;
		echo $id."-Data berhasil disimpan.";
	}
}
else
{
	$id=$reqId;
	$inventaris_penyusutan->setField("TANGGAL_SUSUT", dateToDBCheck($reqTanggalSusut));
	$inventaris_penyusutan->setField("KETERANGAN", $reqKeterangan);
	$inventaris_penyusutan->setField("JENIS_SUSUT_ID", $reqJenisSusut);
	$inventaris_penyusutan->setField("NAMA", $reqNama);
	$inventaris_penyusutan->setField("TANGGAL", "CURRENT_DATE");	
	$inventaris_penyusutan->setField("INVENTARIS_PENYUSUTAN_ID", $reqId);
	
	
	$inventaris_penyusutan->setField("LAST_UPDATE_USER", $userLogin->nama);
	$inventaris_penyusutan->setField("LAST_UPDATE_DATE", "CURRENT_DATE");
	
	if($inventaris_penyusutan->update())
		echo $id."-Data berhasil disimpan.";
	
}
?>