<?
/* INCLUDE FILE */
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrGeneralRefD.php");

$jurnal = new KbbrGeneralRefD();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqIdRefData= httpFilterPost("reqIdRefData");
$reqIdRefDataTemp= httpFilterPost("reqIdRefDataTemp");
$reqNama= httpFilterPost("reqNama");
$reqKeterangan= httpFilterPost("reqKeterangan");

if($reqMode == "insert")
{
	$jurnal->setField("KD_CABANG", "11");
	$jurnal->setField("JENIS_FILE", "R");
	$jurnal->setField("ID_FILE", "GENREFD");
	$jurnal->setField("PROGRAM_NAME", "KBBR_GENERAL_REF");
	$jurnal->setField("ID_REF_FILE", "JENISJURNAL");
	
	$jurnal->setField("KET_REF_DATA", $reqKeterangan);
	$jurnal->setField("KD_AKTIF", "A");
	$jurnal->setField("ID_REF_DATA", strtoupper($reqIdRefData));
	$jurnal->setField("LAST_UPDATED_BY", $userLogin->nama);
	$jurnal->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
	$jurnal->setField("PROGRAM_NAME", "KBB_R_JEN_JURNAL_IMAIS");
	
	if($jurnal->insert())
		echo "Data berhasil disimpan.";
}
else
{
	$jurnal->setField("ID_REF_DATA_TEMP", $reqIdRefDataTemp);
	$jurnal->setField("KD_AKTIF", "A");
	$jurnal->setField("ID_REF_FILE", "JENISJURNAL");
	$jurnal->setField("KET_REF_DATA", $reqKeterangan);
	$jurnal->setField("ID_REF_DATA", strtoupper($reqIdRefData));
	$jurnal->setField("LAST_UPDATED_BY", $userLogin->nama);
	$jurnal->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
		
	if($jurnal->update())
		echo "Data berhasil disimpan.";
}
?>