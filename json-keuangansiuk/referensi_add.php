<?
/* INCLUDE FILE */
include_once("../WEB-INF/classes/utils/UserLogin.php");
include_once("../WEB-INF/functions/string.func.php");
include_once("../WEB-INF/functions/default.func.php");
include_once("../WEB-INF/functions/date.func.php");
include_once("../WEB-INF-SIUK/classes/base-keuangansiuk/KbbrGeneralRef.php");


$referensi = new KbbrGeneralRef();

$reqId = httpFilterPost("reqId");
$reqMode = httpFilterPost("reqMode");
$reqNama= httpFilterPost("reqNama");
$reqKeterangan= httpFilterPost("reqKeterangan");
$reqStatus= httpFilterPost("reqStatus");

$reqKodeCabang= httpFilterPost("reqKodeCabang");
$reqJenisFile= httpFilterPost("reqJenisFile");
$reqIdFile= httpFilterPost("reqIdFile");
$reqProgramNama= httpFilterPost("reqProgramNama");

if($reqMode == "insert")
{
	$referensi->setField("KD_CABANG", $reqKodeCabang);
	$referensi->setField("JENIS_FILE", $reqJenisFile);
	$referensi->setField("ID_FILE", $reqIdFile);
	$referensi->setField("PROGRAM_NAME", $reqProgramNama);
	
	$referensi->setField("ID_REF_FILE", $reqNama);
	$referensi->setField("KET_REFERENCE", $reqKeterangan);
	$referensi->setField("KD_AKTIF", $reqStatus);
	
	$referensi->setField("LAST_UPDATED_BY", $userLogin->nama);
	$referensi->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
		
	if($referensi->insert())
		echo "Data berhasil disimpan.";
		
}
else
{
	$referensi->setField('ID_REF_FILE_TEMP', $reqId); 
	$referensi->setField("ID_REF_FILE", $reqNama);
	$referensi->setField("KET_REFERENCE", $reqKeterangan);
	$referensi->setField("KD_AKTIF", $reqStatus);
	$referensi->setField("LAST_UPDATED_BY", $userLogin->nama);
	$referensi->setField("LAST_UPDATE_DATE", OCI_SYSDATE);
		
	if($referensi->update())
		echo "Data berhasil disimpan.";
}
?>